<script src="https://cdn.tailwindcss.com"></script>

<aside class="w-64 h-screen bg-blue-900 text-white fixed">
    <div class="p-6 text-center border-b border-white">
        <h1 class="text-xl font-bold">Candidate Management System</h1>
    </div>
    <nav class="mt-6">
        <ul class="font-semibold">
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-blue-700' : 'hover:bg-blue-700' ?> shadow-xl">
                <a href="../dashboard/dashboard.php" class="flex items-center py-6 px-4 space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                        <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'internal_list.php' ? 'bg-blue-700' : 'hover:bg-blue-700' ?> shadow-xl">
                <a href="../internal/internal_list.php" class="flex items-center py-6 px-4 space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                    <span>Kandidat Internal</span>
                </a>
            </li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'eksternal_list.php' ? 'bg-blue-700' : 'hover:bg-blue-700' ?> shadow-xl">
                <a href="../eksternal/eksternal_list.php" class="flex items-center py-6 px-4 space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                    <span>Kandidat Eksternal</span>
                </a>
            </li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'interview_list.php' ? 'bg-blue-700' : 'hover:bg-blue-700' ?> shadow-xl">
                <a href="../interview/interview_list.php" class="flex items-center py-6 px-4 space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                        <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
                    </svg>
                    <span>Kandidat Interview</span>
                </a>
            </li>
            <li class="<?= basename($_SERVER['PHP_SELF']) == 'keberangkatan_list.php' ? 'bg-blue-700' : 'hover:bg-blue-700' ?> shadow-xl">
                <a href="../keberangkatan/keberangkatan_list.php" class="flex items-center py-6 px-4 space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                        <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                    </svg>
                    <span>Kandidat Keberangkatan</span>
                </a>
            </li>
            <li class="bg-red-600 hover:bg-red-400 shadow-xl">
                <a href="#" onclick="openLogoutModal()" class="flex items-center py-6 px-4 space-x-3 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

</aside>

<!-- Modal Konfirmasi Logout -->
<div id="logoutConfirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center min-h-screen z-50">
    <div class="bg-gray-900 p-6 rounded-lg shadow-lg w-96 modal">
        <h2 class="text-xl text-white font-bold mb-4">ログアウトの確認</h2>
        <p id="logoutModalMessage" class="mb-4 text-white ">本当にログアウトしてもよろしいですか？</p>
        <div class="flex justify-end">
            <button onclick="closeLogoutModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">キャンセル</button>
            <button id="confirmLogoutBtn" class="bg-red-600 text-white px-4 py-2 rounded">ログアウト</button>
        </div>
    </div>
</div>

<!-- JavaScript untuk Modal Konfirmasi Logout -->
<script>
    // Membuka modal konfirmasi logout
    function openLogoutModal() {
        document.getElementById('logoutConfirmationModal').classList.remove('hidden');
    }

    // Menutup modal konfirmasi logout
    function closeLogoutModal() {
        document.getElementById('logoutConfirmationModal').classList.add('hidden');
    }

    // Aksi setelah tombol logout dikonfirmasi
    document.getElementById('confirmLogoutBtn').onclick = function() {
        window.location.href = '../../logout.php'; // Redirect ke halaman logout
    };
</script>