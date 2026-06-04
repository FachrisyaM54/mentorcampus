@extends('layouts.app')

@section('content')

<style>
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: all .3s ease-out;
        opacity: 0;
    }

    .faq-item.active .faq-answer {
        max-height: 500px;
        opacity: 1;
        padding-bottom: 1.5rem;
    }

    .faq-item {
        transition: all .2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .faq-item:hover {
        background: #f8faff;
    }

    .faq-item.active .icon-chevron {
        transform: rotate(180deg);
        color: #175BAF;
    }
</style>

<div class="pt-16">

    {{-- HERO --}}
    <header class="relative w-full h-[450px] flex items-center justify-center overflow-hidden">

        <img
            src="{{ asset('image/priabelajar.jpg') }}"
            alt="FAQ"
            class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]"></div>

        <div class="relative z-10 text-center px-6">

            <span class="px-4 py-1 bg-blue-500 text-white text-[10px] font-bold rounded-full uppercase tracking-widest mb-4 inline-block">
                Help Center
            </span>

            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">
                Apa yang bisa kami bantu?
            </h1>

            <div class="max-w-2xl mx-auto relative">

                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>

                <input
                    type="text"
                    id="faqSearch"
                    placeholder="Cari pertanyaan kamu di sini..."
                    class="w-full py-5 pl-14 pr-6 bg-white rounded-2xl shadow-2xl outline-none text-slate-700 text-lg">

            </div>

        </div>

    </header>

    {{-- FAQ --}}
    <section class="max-w-4xl mx-auto px-6 py-20">

        @foreach($faqCategories as $category => $items)

            <div class="mb-16 category-section">

                <div class="flex items-center gap-4 mb-8">

                    <h2 class="text-2xl font-extrabold text-slate-800 whitespace-nowrap">
                        {{ $category }}
                    </h2>

                    <div class="h-px w-full bg-slate-100"></div>

                </div>

                <div class="divide-y divide-slate-100">

                    @foreach($items as $item)

                        <div class="faq-item group">

                            <button
                                onclick="toggleAccordion(this)"
                                class="w-full flex items-center justify-between py-6 text-left">

                                <span class="text-lg font-semibold text-slate-700 group-hover:text-[#175BAF] transition-colors pr-8">
                                    {{ $item['q'] }}
                                </span>

                                <i class="fa-solid fa-chevron-down icon-chevron text-slate-300 transition-transform duration-300"></i>

                            </button>

                            <div class="faq-answer">

                                <p class="text-slate-500 leading-relaxed text-[16px]">
                                    {{ $item['a'] }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endforeach

        {{-- SUPPORT --}}
        <div class="mt-24 p-12 bg-slate-50 rounded-[3rem] border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">

            <div class="text-center md:text-left">

                <h3 class="text-2xl font-bold text-slate-800 mb-2">
                    Masih bingung?
                </h3>

                <p class="text-slate-500">
                    Hubungi tim kami untuk bantuan lebih lanjut via email.
                </p>

            </div>

            <a
                href="mailto:support@mentorcampus.id"
                class="px-10 py-4 bg-[#175BAF] text-white font-bold rounded-2xl hover:bg-blue-700 transition shadow-lg">

                Hubungi Support

            </a>

        </div>

    </section>

</div>

<script>

function toggleAccordion(btn){

    const item = btn.parentElement;

    document.querySelectorAll('.faq-item').forEach(el => {
        if(el !== item){
            el.classList.remove('active');
        }
    });

    item.classList.toggle('active');
}

document.getElementById('faqSearch')
.addEventListener('input', function(e){

    const val = e.target.value.toLowerCase();

    document.querySelectorAll('.faq-item')
    .forEach(item => {

        const text = item.innerText.toLowerCase();

        item.style.display =
            text.includes(val)
            ? 'block'
            : 'none';

    });

    document.querySelectorAll('.category-section')
    .forEach(sec => {

        const visible =
            [...sec.querySelectorAll('.faq-item')]
            .some(i => i.style.display !== 'none');

        sec.style.display =
            visible
            ? 'block'
            : 'none';

    });

});
</script>

@endsection