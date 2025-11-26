    <?php
// Partial: Barra de búsqueda reutilizable
$q = isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : '';
?>
<form action="index.php?controller=Producto&action=index" method="get" class="search-box-netflix mx-auto">
  <input type="hidden" name="controller" value="Producto">
  <input type="hidden" name="action" value="index">
  <button type="submit" aria-label="Buscar">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
      <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
  <input name="q" value="<?= $q ?>" placeholder="Buscar..." aria-label="Buscar" />
</form>
