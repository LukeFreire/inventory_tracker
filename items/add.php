<?php
require '../functions.php';
ensure_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['name']);
    $description  = trim($_POST['description']);
    $quantity     = (int)$_POST['quantity_on_hand'];
    $reorder      = (int)$_POST['reorder_level'];
    $category_id  = (int)$_POST['category_id'];
    $supplier_id  = (int)$_POST['supplier_id'];

    $stmt = $pdo->prepare(
        "INSERT INTO items 
         (category_id, supplier_id, name, description, quantity_on_hand, reorder_level) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $category_id,
        $supplier_id,
        $name,
        $description,
        $quantity,
        $reorder
    ]);

    redirect('list.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers  = $pdo->query("SELECT * FROM suppliers")->fetchAll();

include '../header.php';
?>
<h2>Add New Item</h2>
<form method="post">
    <label>Name:
        <input type="text" name="name" required>
    </label><br>
    <label>Description:
        <textarea name="description"></textarea>
    </label><br>
    <label>Quantity On Hand:
        <input type="number" name="quantity_on_hand" value="0" required>
    </label><br>
    <label>Reorder Level:
        <input type="number" name="reorder_level" value="0" required>
    </label><br>
    <label>Category:
        <select name="category_id" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Supplier:
        <select name="supplier_id" required>
            <?php foreach ($suppliers as $s): ?>
                <option value="<?= $s['id'] ?>">
                    <?= htmlspecialchars($s['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <button type="submit">Add Item</button>
</form>
<?php include '../footer.php'; ?>
