<?php
// items/list.php

require '../functions.php';
ensure_logged_in();

$search           = isset($_GET['q'])             ? trim($_GET['q'])            : '';
$category_filter  = isset($_GET['category_id'])   ? (int)$_GET['category_id']   : 0;
$supplier_filter  = isset($_GET['supplier_id'])   ? (int)$_GET['supplier_id']   : 0;
$page             = isset($_GET['page'])          ? max(1, (int)$_GET['page'])  : 1;
$perPage          = 10;
$offset           = ($page - 1) * $perPage;

$conditions = [];
$params     = [];

if ($search !== '') {
    $conditions[] = '(i.name LIKE ? OR i.description LIKE ?)';
    $params[]     = "%{$search}%";
    $params[]     = "%{$search}%";
}

if ($category_filter > 0) {
    $conditions[] = 'i.category_id = ?';
    $params[]     = $category_filter;
}

if ($supplier_filter > 0) {
    $conditions[] = 'i.supplier_id = ?';
    $params[]     = $supplier_filter;
}

$where = $conditions
    ? 'WHERE ' . implode(' AND ', $conditions)
    : '';

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM items i $where");
$countStmt->execute($params);
$totalItems = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalItems / $perPage);

$sql  = "
  SELECT i.*, c.name AS category, s.name AS supplier
    FROM items i
    JOIN categories c ON i.category_id = c.id
    JOIN suppliers s ON i.supplier_id = s.id
    $where
    ORDER BY i.name ASC
    LIMIT {$perPage} OFFSET {$offset}
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$suppliers  = $pdo->query("SELECT id, name FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);

include '../header.php';
?>

<h2>Items</h2>

<!-- Search & Filter Form -->
<form method="get" style="margin-bottom:1rem;">
  <input
    type="text"
    name="q"
    placeholder="Search items..."
    value="<?= htmlspecialchars($search) ?>"
  >

  <select name="category_id">
    <option value="0">-- All Categories --</option>
    <?php foreach ($categories as $c): ?>
      <option
        value="<?= $c['id'] ?>"
        <?= $category_filter === (int)$c['id'] ? 'selected' : '' ?>
      >
        <?= htmlspecialchars($c['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <select name="supplier_id">
    <option value="0">-- All Suppliers --</option>
    <?php foreach ($suppliers as $s): ?>
      <option
        value="<?= $s['id'] ?>"
        <?= $supplier_filter === (int)$s['id'] ? 'selected' : '' ?>
      >
        <?= htmlspecialchars($s['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <button type="submit">Filter</button>
  <a href="add.php" style="margin-left:1rem;">Add New Item</a>
</form>

<!-- Items Table -->
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Category</th>
      <th>Supplier</th>
      <th>Qty</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($items) === 0): ?>
      <tr><td colspan="5">No items found.</td></tr>
    <?php else: ?>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?= htmlspecialchars($it['name']) ?></td>
          <td><?= htmlspecialchars($it['category']) ?></td>
          <td><?= htmlspecialchars($it['supplier']) ?></td>
          <td><?= $it['quantity_on_hand'] ?></td>
          <td>
            <a href="edit.php?id=<?= $it['id'] ?>">Edit</a> |
            <a
              href="delete.php?id=<?= $it['id'] ?>"
              onclick="return confirm('Delete this item?');"
            >
              Delete
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<div class="pagination">
  <?php if ($page > 1): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
      &laquo; Prev
    </a>
  <?php endif; ?>

  <span>Page <?= $page ?> of <?= $totalPages ?></span>

  <?php if ($page < $totalPages): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
      Next &raquo;
    </a>
  <?php endif; ?>
</div>

<?php include '../footer.php'; ?>

