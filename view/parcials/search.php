    <?php
    // Partial: Barra de búsqueda reutilizable
    $q = isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : '';
    ?>
    <form action="index.php?controller=Producto&action=index" method="get" class="search-box-netflix mx-auto">
      <input type="hidden" name="controller" value="Producto">
      <input type="hidden" name="action" value="index">
      <button type="submit" aria-label="Buscar">
        <img src="/MVC/public/icons/search.svg" alt="Buscar" width="24" height="24">
      </button>
      <input name="q" value="<?= $q ?>" placeholder="Buscar..." aria-label="Buscar" />
    </form>