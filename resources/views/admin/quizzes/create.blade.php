<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-indigo-600 mb-6">Buat Kuis Baru</h1>

        <form method="POST" action="{{ route('admin.quizzes.store') }}">
            @csrf
            <div class="mb-4">
                <label class=" font-medium mb-1 text-white">Judul Kuis</label>
                <input type="text" name="title" class="w-full border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class=" font-medium mb-1 text-white">Deskripsi (Opsional)</label>
                <textarea name="description" class="w-full border-gray-300 rounded-lg"></textarea>
            </div>

            <h2 class="text-lg font-semibold mb-2 text-white">Soal-soal</h2>
            <div id="questions"></div>

            <button type="button" id="add-question"
                class="mt-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Tambah Soal
            </button>

            <div class="mt-6">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Simpan Kuis
                </button>
            </div>
        </form>
    </div>

    <script>
        const container = document.getElementById('questions');
        const addBtn = document.getElementById('add-question');
        let index = 0;

        addBtn.addEventListener('click', () => {
            const div = document.createElement('div');
            div.classList.add('border', 'p-4', 'rounded', 'mb-4');
            div.innerHTML = `
                <label class="block mb-1 font-medium text-white">Pertanyaan</label>
                <input name="questions[${index}][question_text]" class="w-full border-gray-300 rounded mb-2" required>

                <div class="grid grid-cols-2 gap-2">
                    <input name="questions[${index}][option_a]" placeholder="Opsi A" class="border-gray-300 rounded" required>
                    <input name="questions[${index}][option_b]" placeholder="Opsi B" class="border-gray-300 rounded" required>
                    <input name="questions[${index}][option_c]" placeholder="Opsi C" class="border-gray-300 rounded" required>
                    <input name="questions[${index}][option_d]" placeholder="Opsi D" class="border-gray-300 rounded" required>
                </div>

                <label class="block mt-2 font-medium text-white">Jawaban Benar (A/B/C/D)</label>
                <input name="questions[${index}][correct_option]" maxlength="1" class="border-gray-300 rounded" required>
            `;
            container.appendChild(div);
            index++;
        });
    </script>
</x-app-layout>