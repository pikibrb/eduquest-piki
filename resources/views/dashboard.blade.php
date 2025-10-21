<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 text-center">
        <h1 class="text-4xl font-bold mb-4 text-indigo-600">Selamat Datang di EduQuest!!!</h1>
        <p class="text-gray-600 mb-8">Website kuis pembelajaran interaktif.</p>

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.quizzes.index') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl transition">Kelola Kuis</a>
        @else
            <a href="{{ route('student.quizzes.index') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition">Mulai Kuis</a>
        @endif
    </div>
</x-app-layout>
