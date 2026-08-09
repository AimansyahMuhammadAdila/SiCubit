<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: { extend: { colors: { "primary": "#1e40af", "secondary": "#64748b" }, fontFamily: { sans: ["Plus Jakarta Sans", "sans-serif"] } } }
        }
    </script>
</head>

<body class="bg-slate-50 font-sans antialiased flex">

    <?= $this->include('admin/layout/sidebar') ?>

    <main class="flex-1 p-8 h-screen overflow-y-auto">
        <?= $this->renderSection('content') ?>
    </main>

</body>

</html>