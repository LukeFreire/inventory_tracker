<?php
require '../functions.php';
ensure_logged_in();

if (!isset($_GET['id'])) {
    redirect('list.php');
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    redirect('list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['name']);
    $description  = trim($_POST['description']);
    $quantity     = (int)$_POST['quantity_on_hand'];
    $reorder      = (int)$_POST['reorder_level'];
    $category_id  = (int)$_POST['category_id'];
    $supplier_id  = (int)$_POST['supplier_id'];

    $stmt = $pdo->prepare(
        "UPDATE items 
         SET category_id = ?, supplier_id = ?, name = ?, description = ?, quantity_on_hand = ?, reorder_level = ?
         WHERE id = ?"
    );
    $stmt->execute([
        $category_id,
        $supplier_id,
        $name,
        $description,
        $quantity,
        $reorder,
        $id
    ]);

    redirect('list.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers  = $pdo->query("SELECT * FROM suppliers")->fetchAll();

include '../header.php';
?>
<h2>Edit Item</h2>
<form method="post">
    <label>Name:
        <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
    </label><br>
    <label>Description:
        <textarea name="description"><?= htmlspecialchars($item['description']) ?></textarea>
    </label><br>
    <label>Quantity On Hand:
        <input type="number" name="quantity_on_hand" value="<?= $item['quantity_on_hand'] ?>" required>
    </label><br>
    <label>Reorder Level:
        <input type="number" name="reorder_level" value="<?= $item['reorder_level'] ?>" required>
    </label><br>
    <label>Category:
        <select name="category_id" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= $item['category_id'] === $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Supplier:
        <select name="supplier_id" required>
            <?php foreach ($suppliers as $s): ?>
                <option value="<?= $s['id'] ?>"
                    <?= $item['supplier_id'] === $s['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <button type="submit">Update Item</button>
</form>
<?php include '../footer.php'; ?>
