<?php
/**
 * Don Barbero - Homepage Rústica
 * @author Dante Testa <https://dantetesta.com.br>
 * @version 2.0.0
 */
$pageTitle = 'Início - ' . APP_NAME;
ob_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
<style>
body{background:#1a1410}
.wood-texture{background:linear-gradient(135deg,#2d2416 0%,#1a1410 100%);position:relative}
.wood-texture::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background-image:repeating-linear-gradient(90deg,rgba(139,69,19,0.05) 0px,transparent 1px,transparent 2px,rgba(139,69,19,0.05) 3px),repeating-linear-gradient(0deg,rgba(139,69,19,0.05) 0px,transparent 1px,transparent 2px,rgba(139,69,19,0.05) 3px);opacity:0.3}
</style>

<section class="wood-texture text-white py-24 px-4 relative overflow-hidden">
<div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/40"></div>
<div class="container mx-auto max-w-6xl relative z-10 text-center">
<h1 class="text-6xl md:text-8xl font-bold mb-2" style="color:#d4af37;font-family:'Playfair Display',serif;text-shadow:2px 2px 4px rgba(0,0,0,0.8)">Don Barbero</h1>
<div style="color:#b87333;font-size:0.875rem;letter-spacing:0.3em;font-weight:300">BARBEARIA CLÁSSICA</div>
<div class="flex items-center justify-center gap-4 my-8">
<div class="h-px bg-gradient-to-r from-transparent via-amber-600 to-transparent w-32"></div>
<div class="text-2xl" style="color:#d4af37">✂</div>
<div class="h-px bg-gradient-to-r from-transparent via-amber-600 to-transparent w-32"></div>
</div>
<p class="text-xl md:text-2xl text-amber-100 mb-12 max-w-2xl mx-auto" style="font-family:'Playfair Display',serif">Tradição, estilo e maestria em cada corte<br><span class="text-base opacity-80">Agende seu horário de forma rápida e prática</span></p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<?php if(isAuthenticated()):?>
<a href="<?=url('/dashboard')?>" class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-black font-bold py-4 px-10 rounded-sm text-lg transition-all shadow-2xl border border-amber-500/50">⚡ Meus Agendamentos</a>
<?php else:?>
<a href="<?=url('/auth/register')?>" class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-black font-bold py-4 px-10 rounded-sm text-lg transition-all shadow-2xl border border-amber-500/50">🪒 Agendar Agora</a>
<a href="<?=url('/auth/login')?>" class="bg-stone-800/80 hover:bg-stone-700 text-amber-100 font-bold py-4 px-10 rounded-sm text-lg transition-all shadow-2xl border border-amber-900/30">Entrar</a>
<?php endif;?>
</div>
</div>
</section>

<section class="py-20 px-4 bg-stone-900">
<div class="container mx-auto max-w-6xl">
<div class="text-center mb-16">
<h2 class="text-5xl font-bold mb-4" style="color:#d4af37;font-family:'Playfair Display',serif">Nossos Serviços</h2>
<div class="h-1 w-24 bg-gradient-to-r from-transparent via-amber-600 to-transparent mx-auto"></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="bg-gradient-to-br from-stone-800 to-stone-900 p-8 rounded-sm shadow-2xl border border-amber-900/20 hover:border-amber-600/50 transition-all group">
<div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform">💈</div>
<h3 class="text-2xl font-bold text-amber-400 mb-3 text-center">Cabelo</h3>
<p class="text-amber-100/80 text-center mb-4">Corte clássico ou moderno com acabamento impecável</p>
<div class="text-center"><span class="text-3xl font-bold text-amber-500">R$ 40</span><span class="text-sm text-amber-200/60 block mt-1">45 minutos</span></div>
</div>
<div class="bg-gradient-to-br from-stone-800 to-stone-900 p-8 rounded-sm shadow-2xl border border-amber-900/20 hover:border-amber-600/50 transition-all group">
<div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform">��</div>
<h3 class="text-2xl font-bold text-amber-400 mb-3 text-center">Barba</h3>
<p class="text-amber-100/80 text-center mb-4">Design e acabamento profissional com navalha</p>
<div class="text-center"><span class="text-3xl font-bold text-amber-500">R$ 30</span><span class="text-sm text-amber-200/60 block mt-1">30 minutos</span></div>
</div>
<div class="bg-gradient-to-br from-amber-900/30 to-stone-900 p-8 rounded-sm shadow-2xl border-2 border-amber-600/50 relative group">
<div class="absolute -top-3 -right-3 bg-amber-600 text-black text-xs font-bold px-3 py-1 rounded-sm">POPULAR</div>
<div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform">⭐</div>
<h3 class="text-2xl font-bold text-amber-400 mb-3 text-center">Combo</h3>
<p class="text-amber-100/80 text-center mb-4">Cabelo + Barba - Pacote completo</p>
<div class="text-center"><span class="text-3xl font-bold text-amber-500">R$ 60</span><span class="text-sm text-amber-200/60 block mt-1">60 minutos</span></div>
</div>
</div>
</div>
</section>

<section class="py-20 px-4" style="background:linear-gradient(180deg,#1a1410 0%,#0f0a08 100%)">
<div class="container mx-auto max-w-6xl">
<div class="text-center mb-16">
<h2 class="text-5xl font-bold mb-4" style="color:#d4af37;font-family:'Playfair Display',serif">Por Que Don Barbero?</h2>
<div class="h-1 w-24 bg-gradient-to-r from-transparent via-amber-600 to-transparent mx-auto"></div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
<div class="text-center p-6"><div class="text-5xl mb-4">🎯</div><h3 class="text-xl font-bold text-amber-400 mb-2">Agendamento Fácil</h3><p class="text-amber-200/70">Reserve em poucos cliques, 24h por dia</p></div>
<div class="text-center p-6"><div class="text-5xl mb-4">⏰</div><h3 class="text-xl font-bold text-amber-400 mb-2">Horários Flexíveis</h3><p class="text-amber-200/70">Escolha o melhor horário para você</p></div>
<div class="text-center p-6"><div class="text-5xl mb-4">👨‍🦱</div><h3 class="text-xl font-bold text-amber-400 mb-2">Profissionais</h3><p class="text-amber-200/70">Barbeiros experientes e qualificados</p></div>
<div class="text-center p-6"><div class="text-5xl mb-4">✅</div><h3 class="text-xl font-bold text-amber-400 mb-2">Cancelamento Fácil</h3><p class="text-amber-200/70">Política flexível de cancelamento</p></div>
</div>
</div>
</section>

<section class="py-20 px-4 bg-gradient-to-br from-stone-900 via-amber-950 to-stone-900 relative overflow-hidden">
<div class="absolute inset-0 opacity-10">
<div class="absolute top-0 left-0 w-64 h-64 bg-amber-600 rounded-full blur-3xl"></div>
<div class="absolute bottom-0 right-0 w-64 h-64 bg-amber-800 rounded-full blur-3xl"></div>
</div>
<div class="container mx-auto max-w-4xl text-center relative z-10">
<h2 class="text-4xl md:text-5xl font-bold text-amber-400 mb-6" style="font-family:'Playfair Display',serif">Pronto para o Seu Estilo?</h2>
<p class="text-xl text-amber-100 mb-10 max-w-2xl mx-auto">Cadastre-se gratuitamente e agende seu horário<br><span class="text-amber-200/70">Tradição e qualidade em cada atendimento</span></p>
<?php if(!isAuthenticated()):?>
<a href="<?=url('/auth/register')?>" class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-black font-bold py-5 px-12 rounded-sm text-xl transition-all shadow-2xl inline-block border-2 border-amber-500">🪒 Começar Agora</a>
<?php endif;?>
</div>
</section>
<?php
$content=ob_get_clean();
require_once VIEWS_PATH.'/layouts/app.php';
?>
