<?php
function e($valor) { return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8'); }
$formulario = in_array($acao, ['novo', 'editar'], true);
if (!$personagem) $personagem = ['id'=>'', 'nome'=>'', 'universo'=>'', 'poder'=>'', 'categoria'=>'Herói', 'descricao'=>''];
$categorias = ['Herói', 'Vilão', 'Anti-herói', 'Lenda', 'Outro'];
$cores = ['Herói'=>'hero', 'Vilão'=>'villain', 'Anti-herói'=>'anti', 'Lenda'=>'legend', 'Outro'=>'other'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HeroDex — <?= e($tituloPagina) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="index.php"><span class="brand-mark">H</span><span>HERO<span class="brand-light">DEX</span><small>ARQUIVO DE PERSONAGENS</small></span></a>
  <nav><a href="index.php" class="<?= !$formulario ? 'active' : '' ?>">Explorar</a><a class="nav-cta" href="index.php?acao=novo">+ Adicionar ficha</a></nav>
</header>
<main>
<?php if ($formulario): ?>
  <section class="form-shell">
    <a class="back-link" href="index.php">← Voltar ao arquivo</a>
    <div class="form-heading"><span class="eyebrow">CENTRAL DE REGISTRO / 02</span><h1><?= $acao === 'editar' ? 'Atualizar ficha' : 'Cadastrar personagem' ?></h1><p>Registre os dados para manter o arquivo organizado.</p></div>
    <?php if ($erro): ?><div class="alert error"><?= e($erro) ?></div><?php endif; ?>
    <form method="post" action="index.php?acao=<?= $acao === 'editar' ? 'editar' : 'novo' ?>" class="character-form">
      <input type="hidden" name="id" value="<?= e($personagem['id']) ?>">
      <label>Nome do personagem <input name="nome" required maxlength="100" value="<?= e($personagem['nome']) ?>" placeholder="Ex.: Mulher-Maravilha"></label>
      <div class="form-row">
        <label>Universo / franquia <input name="universo" required maxlength="100" value="<?= e($personagem['universo']) ?>" placeholder="Ex.: DC Comics"></label>
        <label>Classificação <select name="categoria"><?php foreach ($categorias as $cat): ?><option <?= $personagem['categoria']===$cat?'selected':'' ?> value="<?= e($cat) ?>"><?= e($cat) ?></option><?php endforeach; ?></select></label>
      </div>
      <label>Habilidade principal <input name="poder" required maxlength="100" value="<?= e($personagem['poder']) ?>" placeholder="Ex.: Superforça e voo"></label>
      <label>Notas do arquivo <textarea name="descricao" rows="4" maxlength="500" placeholder="Uma breve descrição..."><?= e($personagem['descricao']) ?></textarea></label>
      <div class="form-actions"><a class="button button-muted" href="index.php">Cancelar</a><button class="button button-primary" type="submit"><?= $acao === 'editar' ? 'Salvar alterações' : 'Guardar ficha' ?> ↗</button></div>
    </form>
  </section>
<?php else: ?>
  <section class="hero">
    <div class="hero-copy"><span class="eyebrow">ENCICLOPÉDIA • EDIÇÃO 001</span><h1>Todo personagem<br>tem uma <em>história.</em></h1><p>Explore habilidades, universos e figuras extraordinárias em um só lugar.</p><a class="button button-primary" href="index.php?acao=novo">Cadastrar personagem <span>↗</span></a></div>
    <div class="hero-stamp"><span>HD</span><small>CATÁLOGO<br>INDEPENDENTE</small><b>★</b></div>
    <div class="hero-number">01 <span>/ 05</span></div>
  </section>
  <section class="catalog">
    <div class="section-head"><div><span class="eyebrow">O ACERVO</span><h2>Fichas cadastradas <span class="count"><?= count($personagens) ?></span></h2></div>
      <form class="search" method="get" action="index.php"><span>⌕</span><input type="search" name="busca" value="<?= e($busca) ?>" placeholder="Nome, universo ou poder"><button type="submit">Buscar</button><?php if ($busca !== ''): ?><a class="clear" href="index.php">Limpar</a><?php endif; ?></form>
    </div>
    <?php if ($mensagem): ?><div class="alert success"><?= e($mensagem) ?></div><?php endif; ?>
    <div class="character-grid">
    <?php foreach ($personagens as $i => $p): $cat = $p['categoria'] ?: 'Outro'; ?>
      <article class="character-card <?= e($cores[$cat] ?? 'other') ?>">
        <div class="card-top"><span class="serial">FICHA Nº <?= str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT) ?></span><span class="category"><?= e($cat) ?></span></div>
        <div class="avatar" aria-hidden="true"><span><?= e(mb_strtoupper(mb_substr($p['nome'], 0, 1, 'UTF-8'), 'UTF-8')) ?></span><i><?= sprintf('%02d', $i + 1) ?></i></div>
        <div class="card-info"><span class="universe"><?= e($p['universo']) ?></span><h3><?= e($p['nome']) ?></h3><p class="power-label">HABILIDADE PRINCIPAL</p><p class="power"><?= e($p['poder']) ?></p><?php if (!empty($p['descricao'])): ?><p class="description"><?= e($p['descricao']) ?></p><?php endif; ?></div>
        <div class="card-actions"><a href="index.php?acao=editar&id=<?= (int)$p['id'] ?>">Editar ficha ↗</a><a class="delete" href="index.php?acao=excluir&id=<?= (int)$p['id'] ?>" onclick="return confirm('Deseja realmente excluir este personagem?')">Excluir</a></div>
      </article>
    <?php endforeach; ?>
    </div>
    <?php if (!$personagens): ?><div class="empty"><div>＋</div><h3>Nenhuma ficha encontrada</h3><p>Adicione um personagem ou tente outro termo na busca.</p><a class="button button-primary" href="index.php?acao=novo">Criar primeira ficha</a></div><?php endif; ?>
  </section>
<?php endif; ?>
</main>
<footer><span>HERO<span class="brand-light">DEX</span> © <?= date('Y') ?></span><span>UM PROJETO DE CATÁLOGO COM ARQUITETURA MVC</span></footer>
</body>
</html>
