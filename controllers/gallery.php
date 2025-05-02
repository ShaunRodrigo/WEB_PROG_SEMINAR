<?php
include 'db/database.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<main class='auth-message'><p>You need to be logged in to view or upload images.</p></main>";
    exit;
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['image']['tmp_name']);

    if ($check !== false) {
        if ($_FILES['image']['size'] > 5000000) {
            $uploadMessage = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $uploadMessage = "Only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $uploadMessage = "File " . htmlspecialchars(basename($_FILES['image']['name'])) . " uploaded successfully!";
        } else {
            $uploadMessage = "There was an error uploading your file.";
        }
    } else {
        $uploadMessage = "The file is not a valid image.";
    }
}

// Get all uploaded images
$images = array_diff(scandir('uploads/'), array('..', '.'));
?>

<main class="gallery-page">
    <section class="section-header">
        <h2>Image Gallery</h2>
        <p>Browse fan art, posters, and user uploads. Add your own to the collection!</p>
    </section>

    <!-- Upload Form -->
    <section class="upload-form">
        <?php if (isset($uploadMessage)) : ?>
            <p class="upload-message"><?= $uploadMessage ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" class="btn-primary">Upload Image</button>
        </form>
    </section>

    <!-- Gallery -->
    <section class="image-gallery">
        <?php if (!empty($images)) : ?>
            <div class="gallery-grid">
                <?php foreach ($images as $image) : ?>
                    <div class="gallery-item">
                        <img src="uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($image) ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="no-images">No images uploaded yet.</p>
        <?php endif; ?>
    </section>
</main>