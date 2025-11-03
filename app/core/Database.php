<?php
/**
 * Don Barbero - Database Connection (Supabase REST API)
 * 
 * @author Dante Testa <https://dantetesta.com.br>
 * @created 03/11/2025 15:46
 * @version 1.0.0
 */

declare(strict_types=1);

namespace core;

class Database {
    private string $url;
    private string $key;
    private array $defaultHeaders;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->url = rtrim(SUPABASE_URL, '/');
        $this->key = SUPABASE_KEY;
        
        $this->defaultHeaders = [
            'apikey: ' . $this->key,
            'Authorization: Bearer ' . $this->key,
            'Content-Type: application/json',
            'Prefer: return=representation'
        ];
    }
    
    /**
     * SELECT - Buscar registros
     * 
     * @param string $table Nome da tabela
     * @param array $params Parâmetros de busca (select, filters, order, limit)
     * @return array Array de resultados
     */
    public function select(string $table, array $params = []): array {
        $url = $this->url . '/rest/v1/' . $table;
        
        // Construir query string
        $queryParams = [];
        
        if (!empty($params['select'])) {
            $queryParams['select'] = $params['select'];
        }
        
        // Filtros (WHERE)
        if (!empty($params['filters'])) {
            foreach ($params['filters'] as $key => $value) {
                if (is_array($value)) {
                    // Operador customizado (ex: ['operator' => 'gte', 'value' => 10])
                    $operator = $value['operator'] ?? 'eq';
                    $queryParams[$key] = $operator . '.' . $value['value'];
                } else {
                    // Igualdade simples
                    $queryParams[$key] = 'eq.' . $value;
                }
            }
        }
        
        // Ordenação
        if (!empty($params['order'])) {
            $queryParams['order'] = $params['order'];
        }
        
        // Limit
        if (!empty($params['limit'])) {
            $queryParams['limit'] = (string)$params['limit'];
        }
        
        // Offset
        if (!empty($params['offset'])) {
            $queryParams['offset'] = (string)$params['offset'];
        }
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        $response = $this->request('GET', $url);
        
        return $response['data'] ?? [];
    }
    
    /**
     * INSERT - Inserir registro(s)
     * 
     * @param string $table Nome da tabela
     * @param array $data Dados a inserir (pode ser array de arrays para múltiplos)
     * @return array Registro(s) inserido(s)
     */
    public function insert(string $table, array $data): array {
        $url = $this->url . '/rest/v1/' . $table;
        
        $response = $this->request('POST', $url, $data);
        
        return $response['data'] ?? [];
    }
    
    /**
     * UPDATE - Atualizar registro(s)
     * 
     * @param string $table Nome da tabela
     * @param array $data Dados a atualizar
     * @param array $filters Filtros (WHERE)
     * @return array Registro(s) atualizado(s)
     */
    public function update(string $table, array $data, array $filters): array {
        $url = $this->url . '/rest/v1/' . $table;
        
        // Adicionar filtros na URL
        $queryParams = [];
        foreach ($filters as $key => $value) {
            $queryParams[$key] = 'eq.' . $value;
        }
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        $response = $this->request('PATCH', $url, $data);
        
        return $response['data'] ?? [];
    }
    
    /**
     * DELETE - Deletar registro(s)
     * 
     * @param string $table Nome da tabela
     * @param array $filters Filtros (WHERE)
     * @return bool Sucesso
     */
    public function delete(string $table, array $filters): bool {
        $url = $this->url . '/rest/v1/' . $table;
        
        // Adicionar filtros na URL
        $queryParams = [];
        foreach ($filters as $key => $value) {
            $queryParams[$key] = 'eq.' . $value;
        }
        
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        
        $response = $this->request('DELETE', $url);
        
        return $response['success'] ?? false;
    }
    
    /**
     * Buscar um único registro por ID
     * 
     * @param string $table Nome da tabela
     * @param string $id ID do registro
     * @param string $idColumn Nome da coluna ID (default: 'id')
     * @return array|null Registro ou null
     */
    public function findById(string $table, string $id, string $idColumn = 'id'): ?array {
        $results = $this->select($table, [
            'filters' => [$idColumn => $id],
            'limit' => 1
        ]);
        
        return $results[0] ?? null;
    }
    
    /**
     * Buscar um único registro por filtros
     * 
     * @param string $table Nome da tabela
     * @param array $filters Filtros
     * @return array|null Registro ou null
     */
    public function findOne(string $table, array $filters): ?array {
        $results = $this->select($table, [
            'filters' => $filters,
            'limit' => 1
        ]);
        
        return $results[0] ?? null;
    }
    
    /**
     * Executar query RPC (stored procedure)
     * 
     * @param string $functionName Nome da função
     * @param array $params Parâmetros
     * @return array Resultado
     */
    public function rpc(string $functionName, array $params = []): array {
        $url = $this->url . '/rest/v1/rpc/' . $functionName;
        
        $response = $this->request('POST', $url, $params);
        
        return $response['data'] ?? [];
    }
    
    /**
     * Fazer requisição HTTP
     * 
     * @param string $method Método HTTP
     * @param string $url URL completa
     * @param array|null $data Dados do body
     * @return array Resposta
     */
    private function request(string $method, string $url, ?array $data = null): array {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->defaultHeaders);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data !== null && in_array($method, ['POST', 'PATCH', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        // Timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        
        // SSL (em produção)
        if (APP_ENV === 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        // Log de erro
        if ($error) {
            error_log("Supabase Request Error: {$error}");
            return ['success' => false, 'error' => $error];
        }
        
        // Decode response
        $decodedResponse = json_decode($response, true);
        
        // Verificar status code
        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data' => $decodedResponse,
                'status_code' => $httpCode
            ];
        } else {
            error_log("Supabase HTTP Error {$httpCode}: {$response}");
            return [
                'success' => false,
                'error' => $decodedResponse['message'] ?? 'Unknown error',
                'status_code' => $httpCode,
                'details' => $decodedResponse
            ];
        }
    }
    
    /**
     * Testar conexão com Supabase
     * 
     * @return bool True se conectado
     */
    public function testConnection(): bool {
        try {
            $response = $this->select('services', ['limit' => 1]);
            return true;
        } catch (\Exception $e) {
            error_log("Supabase Connection Test Failed: " . $e->getMessage());
            return false;
        }
    }
}
