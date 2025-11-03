<?php
/**
 * Don Barbero - Relatórios Financeiros
 * 
 * @author Dante Testa <https://dantetesta.com.br>
 * @created 03/11/2025 16:34
 * @version 1.0.0
 */

$pageTitle = 'Relatórios Financeiros - ' . APP_NAME;
ob_start();
?>

<section class="py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="container mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Relatórios Financeiros</h1>
            <p class="text-gray-600">Análise completa de faturamento e agendamentos</p>
        </div>
        
        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="<?= url('/admin/finance') ?>" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                    <input type="date" name="start_date" value="<?= e($_GET['start_date'] ?? date('Y-m-01')) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                    <input type="date" name="end_date" value="<?= e($_GET['end_date'] ?? date('Y-m-d')) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        Filtrar
                    </button>
                    <a href="<?= url('/admin/finance') ?>?start_date=<?= e($_GET['start_date'] ?? date('Y-m-01')) ?>&end_date=<?= e($_GET['end_date'] ?? date('Y-m-d')) ?>&export=csv" 
                       class="px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        📥 Exportar CSV
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Cards de Totais -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-600 mb-1">Total de Agendamentos</div>
                <div class="text-3xl font-bold text-gray-900"><?= $report['total_appointments'] ?></div>
            </div>
            <div class="bg-blue-50 rounded-lg shadow p-6">
                <div class="text-sm text-blue-700 mb-1">Faturamento Total</div>
                <div class="text-3xl font-bold text-blue-900"><?= formatMoney($report['total_revenue']) ?></div>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-6">
                <div class="text-sm text-green-700 mb-1">Recebido</div>
                <div class="text-3xl font-bold text-green-900"><?= formatMoney($report['total_paid']) ?></div>
            </div>
            <div class="bg-orange-50 rounded-lg shadow p-6">
                <div class="text-sm text-orange-700 mb-1">A Receber</div>
                <div class="text-3xl font-bold text-orange-900"><?= formatMoney($report['total_pending']) ?></div>
            </div>
        </div>
        
        <!-- Por Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Por Status</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($report['by_status'] as $status => $data): ?>
                    <?php if ($data['count'] > 0): ?>
                        <div class="border rounded-lg p-4">
                            <div class="text-sm text-gray-600 mb-1"><?= ucfirst($status) ?></div>
                            <div class="text-2xl font-bold text-gray-900"><?= $data['count'] ?></div>
                            <div class="text-sm text-blue-600 font-semibold"><?= formatMoney($data['revenue']) ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Por Serviço -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Por Serviço</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($report['by_service'] as $service => $data): ?>
                    <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="text-lg font-bold text-gray-900 mb-2"><?= e($service) ?></div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Quantidade:</span>
                                <span class="font-semibold text-gray-900"><?= $data['count'] ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Faturamento:</span>
                                <span class="font-semibold text-blue-600"><?= formatMoney($data['revenue']) ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Média:</span>
                                <span class="font-semibold text-gray-900"><?= formatMoney($data['revenue'] / $data['count']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once VIEWS_PATH . '/layouts/app.php';
?>
