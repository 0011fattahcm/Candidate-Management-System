<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'candidate_management');

$error_message = ""; // Variable untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header('Location: ../candidate-management-jeca/pages/dashboard/dashboard.php');
            exit;
        } else {
            $error_message = "ユーザー名またはパスワードが間違っています"; // Set pesan kesalahan
        }
    } else {
        $error_message = "ユーザー名またはパスワードが間違っています!"; // Set pesan kesalahan
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            position: relative;
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            color: white;
            /* Mengubah warna teks agar kontras dengan background gelap */
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna hitam dengan transparansi */
            z-index: -1;
            /* Letakkan overlay di belakang konten */
        }

        .date-time {
            position: fixed;
            top: 10px;
            right: 0;
            /* Ubah posisi ke kanan */
            font-size: 22px;
            /* Memperbesar ukuran font */
            color: white;
            white-space: nowrap;
            overflow: hidden;
            animation: scroll-left 10s linear infinite;
            /* Animasi scrolling */
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
                /* Mulai dari luar kanan */
            }

            100% {
                transform: translateX(-100%);
                /* Bergerak ke luar kiri */
            }
        }
    </style>
    <script>
        // Function to hide the error message after 5 seconds
        function hideErrorMessage() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        }
    </script>
</head>

<body class="flex items-center justify-center min-h-screen" onload="hideErrorMessage()">
    <div id="date-time" class="date-time"></div> <!-- Elemen untuk tanggal dan waktu -->

    <div class="text-center text-white">
        <img src="logo.png" alt="Logo" class="mx-auto rounded-xl shadow-xl mb-4 w-32 h-auto"> <!-- Tempat logo -->
        <h1 class="text-4xl font-bold mb-8">候補者管理システム</h1>
        <!-- Display error message if it exists -->
        <?php if (!empty($error_message)): ?>
            <div id="error-message" class="mb-4 text-red-500 text-center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-lg p-8 w-80 mx-auto">
            <h2 class="text-2xl font-semibold mb-6">ログイン</h2>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-left text-white mb-2">ユーザー名</label>
                    <div class="relative">
                        <input type="text" name="username" id="username" class="w-full px-4 py-2 bg-transparent border-b border-white text-white focus:outline-none" placeholder="ユーザー名" required>
                        <i class="fas fa-user absolute right-3 top-3 text-white"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-left text-white mb-2">パスワード</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-transparent border-b border-white text-white focus:outline-none" placeholder="パスワード" required>
                        <i class="fas fa-lock absolute right-3 top-3 text-white"></i>
                    </div>
                </div>
                <button type="submit" class="w-full py-2 bg-white text-gray-800 font-semibold rounded-lg">ログイン</button>
            </form>
        </div>
    </div>

    <script>
        function getCurrentDateTime() {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long',
                locale: 'ja-JP'
            };
            const date = new Date().toLocaleDateString('ja-JP', options);
            return date;
        }

        function updateDateTime() {
            document.getElementById('date-time').innerText = getCurrentDateTime();
        }

        // Memperbarui tanggal setiap detik
        setInterval(updateDateTime, 1000);
        // Memanggil fungsi sekali untuk pertama kali
        updateDateTime();
    </script>
</body>

</html>