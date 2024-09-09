<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh Sederhana HTML dan CSS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Reset default margin dan padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background: #333;
    color: #fff;
    padding: 10px 0;
    text-align: center;
}

header h1 {
    margin: 0;
}

nav ul {
    list-style: none;
    padding: 0;
}

nav ul li {
    display: inline;
    margin: 0 10px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

main {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

section {
    flex: 2;
    background: #fff;
    padding: 20px;
    margin-right: 10px;
}

aside {
    flex: 1;
    background: #e2e2e2;
    padding: 20px;
}

footer {
    background: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
}

</style>
<body>
    <header>
        <h1><?=$hai?></h1>
        <nav>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Tentang</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Judul Seksi</h2>
            <p>Ini adalah paragraf contoh di dalam seksi utama. Anda dapat menambahkan lebih banyak konten di sini.</p>
        </section>
        <aside>
            <h2>Sidebar</h2>
            <p>Ini adalah konten di sidebar. Anda dapat menambahkan informasi tambahan atau link di sini.</p>
        </aside>
    </main>
    <footer>
        <p>&copy; 2024 Contoh Hak Cipta. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
