<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.lessons.slides.index', $lesson) }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Edit <span class="text-blue-600">Slide</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Materi: {{ $lesson->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ type: '{{ old('type', $slide->type) }}' }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-12 relative">
                <form id="slide-form" method="POST" action="{{ route('admin.lessons.slides.update', [$lesson, $slide]) }}" class="space-y-8">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="content" id="content-json">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="title" :value="__('Judul Slide')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $slide->title)" required />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Tipe Slide')" />
                            <select id="type" name="type" x-model="type" class="block mt-1 w-full bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 focus:border-blue-500 focus:ring-0 rounded-2xl px-4 py-3 text-slate-900 dark:text-white transition duration-200 font-medium shadow-sm">
                                <option value="content">Blok Materi (Editor.js)</option>
                                <option value="quiz">Kuis Cepat</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="type === 'content'" class="space-y-4">
                        <x-input-label :value="__('Konten Materi (Blok)')" />
                        <div class="bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 rounded-[2rem] p-8 min-h-[400px]">
                            <div id="editorjs" class="prose prose-slate dark:prose-invert max-w-none"></div>
                        </div>
                    </div>

                    <div x-show="type === 'quiz'" class="p-10 bg-emerald-50 dark:bg-emerald-500/10 rounded-[2rem] border-2 border-emerald-100 dark:border-emerald-500/20 text-center">
                        <i class='bx bx-question-mark text-5xl text-emerald-500 mb-4'></i>
                        <p class="text-emerald-700 dark:text-emerald-400 font-bold uppercase tracking-tight italic">Tipe Slide Kuis terpilih.</p>
                    </div>

                    <div class="w-32">
                        <x-input-label for="order" :value="__('Urutan')" />
                        <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $slide->order)" required />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="bg-blue-600 text-white font-black py-5 rounded-2xl uppercase tracking-tighter italic text-xl w-full shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-transform">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JSXGraph & Editor.js --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraph.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraphcore.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.30.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.8.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.10.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@2.11.7"></script>

    <style>
        .jxgbox { background-color: transparent !important; border-radius: 1.5rem !important; overflow: hidden; border: 2px solid #f1f5f9 !important; }
        .dark .jxgbox { border: 1px solid rgba(255,255,255,0.1) !important; background-color: #0f172a !important; }
        
        .viz-input {
            width: 100%; background-color: #f8fafc; border: 2px solid #f1f5f9; border-radius: 1rem; padding: 0.75rem 1rem;
            font-size: 0.875rem; font-weight: 700; transition: all 0.2s; color: #1e293b;
        }
        .dark .viz-input { background-color: #0f172a; border-color: rgba(255,255,255,0.05); color: #f8fafc; }
        .viz-input:focus { border-color: #3b82f6; outline: none; }

        .color-picker-box {
            position: relative; height: 3.5rem; width: 100%; border-radius: 1rem; overflow: hidden; border: 2px solid #f1f5f9;
        }
        .dark .color-picker-box { border-color: rgba(255,255,255,0.05); }
        input[type="color"] {
            position: absolute; top: -10px; left: -10px; width: 150%; height: 150%; border: none; cursor: pointer;
        }
    </style>

    <script>
        function safeEval(formula, x) {
            try {
                let processed = formula.replace(/\^/g, '**').replace(/([a-z]+)\(/g, 'Math.$1(');
                const fn = new Function('x', 'return ' + processed);
                return fn(x);
            } catch (e) { return 0; }
        }

        class MathTool {
            static get toolbox() { return { title: 'Math', icon: '<i class="bx bx-math"></i>' }; }
            constructor({data}) { this.data = data.formula || ''; this.wrapper = null; }
            render() {
                this.wrapper = document.createElement('div');
                this.wrapper.className = 'p-4 bg-blue-50 dark:bg-blue-900/10 rounded-xl border-2 border-blue-100 my-2';
                const input = document.createElement('input');
                input.value = this.data; input.placeholder = 'LaTeX...';
                input.className = 'w-full bg-transparent border-none focus:ring-0 font-mono text-blue-700 dark:text-blue-400';
                input.oninput = (e) => { this.data = e.target.value; };
                this.wrapper.appendChild(input);
                return this.wrapper;
            }
            save() { return { formula: this.data }; }
        }

        class VizTool {
            static get toolbox() { return { title: 'Visualisasi (JSX)', icon: '<i class="bx bx-chart"></i>' }; }
            constructor({data}) { 
                this.data = {
                    title: data.title || '',
                    footer: data.footer || '',
                    boundingbox: data.boundingbox || [-1, 10, 11, -1],
                    elements: data.elements || []
                };
                this.board = null;
                this.boardId = 'jxg-' + Math.random().toString(36).substr(2, 9);
            }

            render() {
                this.wrapper = document.createElement('div');
                this.wrapper.className = 'p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border-2 border-amber-200 dark:border-amber-500/20 my-6 shadow-xl';
                this.renderUI();
                return this.wrapper;
            }

            renderUI() {
                this.wrapper.innerHTML = '';
                const header = document.createElement('div');
                header.className = 'flex items-center space-x-3 mb-8 pb-4 border-b border-amber-50 dark:border-amber-900/20';
                header.innerHTML = `<div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 rounded-xl flex items-center justify-center text-amber-600"><i class="bx bx-chart text-2xl"></i></div><div><span class="block text-[10px] font-black uppercase tracking-[0.2em] text-amber-500">JSXGraph Designer</span><span class="block text-sm font-bold text-slate-700 dark:text-slate-200">Interactive Wizard</span></div>`;
                this.wrapper.appendChild(header);

                const previewContainer = document.createElement('div');
                previewContainer.className = 'mb-10 flex flex-col items-center';
                previewContainer.innerHTML = `<span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-3 italic">Live Preview</span><div id="${this.boardId}" class="jxgbox w-full max-w-[440px] aspect-[16/9] bg-white shadow-inner"></div>`;
                this.wrapper.appendChild(previewContainer);

                const form = document.createElement('div');
                form.className = 'space-y-8';
                
                const globalGrid = document.createElement('div');
                globalGrid.className = 'grid grid-cols-2 gap-6';
                globalGrid.innerHTML = `
                    <div><label class="text-[10px] font-black uppercase text-slate-400 block mb-2 tracking-widest">Judul Grafik (LaTeX)</label><input type="text" data-global="title" class="viz-input shadow-sm" value="${this.data.title}" placeholder="f(x) = ..."></div>
                    <div><label class="text-[10px] font-black uppercase text-slate-400 block mb-2 tracking-widest">Bounding Box [x1, y1, x2, y2]</label><input type="text" data-global="boundingbox" class="viz-input shadow-sm" value="${this.data.boundingbox.join(', ')}"></div>
                `;
                globalGrid.querySelectorAll('input').forEach(inp => inp.oninput = (e) => {
                    const key = e.target.dataset.global;
                    this.data[key] = key === 'boundingbox' ? e.target.value.split(',').map(v => parseFloat(v.trim()) || 0) : e.target.value;
                    this.updatePreview();
                });
                form.appendChild(globalGrid);

                const list = document.createElement('div');
                list.className = 'space-y-4';
                this.data.elements.forEach((el, i) => list.appendChild(this.renderElementRow(el, i)));
                form.appendChild(list);

                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'w-full py-4 bg-blue-50 dark:bg-blue-900/10 text-blue-600 rounded-2xl border-2 border-dashed border-blue-200 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-blue-100 transition';
                addBtn.innerHTML = `<i class="bx bx-plus me-1"></i> Tambah Elemen`;
                addBtn.onclick = () => { this.data.elements.push({type: 'function', formula: 'x', color: '#3b82f6'}); this.renderUI(); };
                form.appendChild(addBtn);

                const footerInput = document.createElement('div');
                footerInput.innerHTML = `<label class="text-[10px] font-black uppercase text-slate-400 block mb-2 tracking-widest">Keterangan Bawah</label><input type="text" class="viz-footer viz-input shadow-sm" value="${this.data.footer}">`;
                footerInput.querySelector('input').oninput = (e) => this.data.footer = e.target.value;
                form.appendChild(footerInput);

                this.wrapper.appendChild(form);
                setTimeout(() => this.updatePreview(), 50);
            }

            renderElementRow(el, index) {
                const row = document.createElement('div');
                row.className = 'p-6 bg-slate-50 dark:bg-black/20 rounded-[2rem] border border-slate-100 dark:border-white/5 relative shadow-sm';
                
                let html = `<div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 bg-white dark:bg-slate-800 rounded-full text-[9px] font-black text-blue-500 shadow-sm border border-slate-50 dark:border-white/5">LAYER #${index+1}</span>
                        <select class="el-type bg-white dark:bg-slate-800 border-none rounded-lg text-[9px] font-black uppercase text-slate-500 p-1 px-3 shadow-sm cursor-pointer">
                            <option value="function" ${el.type === 'function' ? 'selected' : ''}>Kurva Fungsi f(x)</option>
                            <option value="integral" ${el.type === 'integral' ? 'selected' : ''}>Daerah Integral</option>
                            <option value="point" ${el.type === 'point' ? 'selected' : ''}>Titik / Node</option>
                        </select>
                    </div>
                    <button type="button" class="el-delete w-8 h-8 flex items-center justify-center bg-white dark:bg-slate-800 text-slate-300 hover:text-red-500 rounded-full transition shadow-sm border border-slate-50 dark:border-white/5"><i class="bx bx-trash"></i></button>
                </div>`;

                if (el.type === 'function' || el.type === 'integral') {
                    html += `<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="text-[8px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Persamaan Matematika</label><input type="text" data-prop="formula" class="viz-input shadow-sm" value="${el.formula || 'x'}" placeholder="x*x"></div>
                        <div><label class="text-[8px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Warna Visual</label><div class="color-picker-box shadow-sm"><input type="color" data-prop="color" value="${el.color || '#3b82f6'}"></div></div>
                    </div>`;
                    if(el.type === 'integral') {
                        html += `<div class="grid grid-cols-2 gap-6 mt-4">
                            <div><label class="text-[8px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Batas A (Kiri)</label><input type="number" data-prop="start" class="viz-input shadow-sm" value="${el.start || 0}"></div>
                            <div><label class="text-[8px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Batas B (Kanan)</label><input type="number" data-prop="end" class="viz-input shadow-sm" value="${el.end || 2}"></div>
                        </div>`;
                    }
                } else {
                    html += `<div class="grid grid-cols-4 gap-4">
                        <div><label class="text-[8px] font-black text-slate-400 block mb-2 uppercase tracking-widest">Pos X</label><input type="number" data-prop="x" class="viz-input shadow-sm" value="${el.x || 0}"></div>
                        <div><label class="text-[8px] font-black text-slate-400 block mb-2 uppercase tracking-widest">Pos Y</label><input type="number" data-prop="y" class="viz-input shadow-sm" value="${el.y || 0}"></div>
                        <div><label class="text-[8px] font-black text-slate-400 block mb-2 uppercase tracking-widest">Label</label><input type="text" data-prop="label" class="viz-input shadow-sm" value="${el.label || ''}"></div>
                        <div><label class="text-[8px] font-black text-slate-400 block mb-2 uppercase tracking-widest">Warna</label><div class="color-picker-box shadow-sm"><input type="color" data-prop="color" value="${el.color || '#ef4444'}"></div></div>
                    </div>`;
                }

                row.innerHTML = html;
                row.querySelector('.el-type').onchange = (e) => { this.data.elements[index].type = e.target.value; this.renderUI(); };
                row.querySelector('.el-delete').onclick = () => { this.data.elements.splice(index, 1); this.renderUI(); };
                
                row.querySelectorAll('input').forEach(inp => {
                    inp.oninput = (e) => {
                        const targetEl = this.data.elements[index];
                        const prop = e.target.getAttribute('data-prop');
                        targetEl[prop] = e.target.type === 'number' ? parseFloat(e.target.value) : e.target.value;
                        this.updatePreview();
                    };
                });

                return row;
            }

            updatePreview() {
                const elId = this.boardId;
                const container = document.getElementById(elId);
                if (!container) return;
                
                container.innerHTML = '';
                if (this.board) { JXG.JSXGraph.freeBoard(this.board); }

                const isDark = document.documentElement.classList.contains('dark');
                const axisColor = isDark ? 'rgba(255,255,255,0.2)' : '#e2e8f0';
                const labelColor = isDark ? '#94a3b8' : '#64748b';

                this.board = JXG.JSXGraph.initBoard(elId, {
                    boundingbox: this.data.boundingbox,
                    axis: { strokeColor: axisColor, ticks: { labelColor: labelColor } }, 
                    showCopyright: false, showNavigation: false, keepaspectratio: false
                });

                this.data.elements.forEach(el => {
                    try {
                        if (el.type === 'function' && el.formula) {
                            const curve = this.board.create('functiongraph', [x => safeEval(el.formula, x)], {strokeColor: el.color, strokeWidth: 3});
                            curve.setAttribute({ strokeColor: el.color }); 
                        } else if (el.type === 'integral' && el.formula) {
                            const f = this.board.create('functiongraph', [x => safeEval(el.formula, x)], {visible: false});
                            const area = this.board.create('integral', [[el.start || 0, el.end || 2], f], {fillColor: el.color, fillOpacity: 0.3, label: {visible: false}});
                            area.setAttribute({ fillColor: el.color });
                        } else if (el.type === 'point') {
                            const p = this.board.create('point', [el.x || 0, el.y || 0], {color: el.color, name: el.label || '', label: {strokeColor: labelColor, fontSize: 14}});
                            p.setAttribute({ color: el.color });
                        }
                    } catch(e) {}
                });
            }

            save() { return this.data; }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const initialDataRaw = @json($slide->content);
            let blocksData = { blocks: [] };
            if (initialDataRaw && typeof initialDataRaw === 'object' && initialDataRaw.blocks) blocksData = initialDataRaw;
            else if (typeof initialDataRaw === 'string' && initialDataRaw.trim() !== '') blocksData = { blocks: [{ type: 'paragraph', data: { text: initialDataRaw } }] };

            const editor = new EditorJS({
                holder: 'editorjs',
                data: blocksData,
                tools: { header: Header, list: List, paragraph: Paragraph, math: MathTool, visualization: VizTool },
                placeholder: 'Tulis materi...',
            });

            document.getElementById('slide-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                const savedData = await editor.save();
                document.getElementById('content-json').value = JSON.stringify(savedData);
                e.target.submit();
            });
        });
    </script>
</x-app-layout>
