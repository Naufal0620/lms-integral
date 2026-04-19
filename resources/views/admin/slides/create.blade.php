<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.lessons.slides.index', $lesson) }}" class="p-3 bg-slate-100 dark:bg-white/5 rounded-2xl hover:bg-slate-200 dark:hover:bg-white/10 transition">
                <i class='bx bx-left-arrow-alt text-2xl text-slate-600 dark:text-slate-400'></i>
            </a>
            <div>
                <h2 class="font-black text-3xl text-slate-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    Tambah <span class="text-blue-600">Slide</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Materi: {{ $lesson->title }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ type: 'content' }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#1e293b] overflow-hidden shadow-2xl rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 p-8 md:p-12 relative">
                <form id="slide-form" method="POST" action="{{ route('admin.lessons.slides.store', $lesson) }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="content" id="content-json">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="title" :value="__('Judul Slide')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Tipe Slide')" />
                            <select id="type" name="type" x-model="type" class="block mt-1 w-full bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 focus:border-blue-500 focus:ring-0 rounded-2xl px-4 py-3 text-slate-900 dark:text-white transition duration-200 font-medium">
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
                        <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $lesson->slides()->count() + 1)" required />
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="bg-blue-600 text-white font-black py-5 rounded-2xl uppercase tracking-tighter italic text-xl w-full shadow-xl shadow-blue-500/20 hover:scale-[1.02] transition-transform">
                            Simpan Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.30.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.8.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.10.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@2.11.7"></script>

    <script>
        class MathTool {
            static get toolbox() { return { title: 'Math', icon: '<i class="bx bx-math"></i>' }; }
            constructor({data}) { this.data = data.formula || ''; this.wrapper = null; }
            render() {
                this.wrapper = document.createElement('div');
                this.wrapper.className = 'p-4 bg-blue-50 dark:bg-blue-900/10 rounded-xl border-2 border-blue-100 my-2';
                const input = document.createElement('input');
                input.value = this.data;
                input.placeholder = 'LaTeX...';
                input.className = 'w-full bg-transparent border-none focus:ring-0 font-mono text-blue-700 dark:text-blue-400';
                input.oninput = (e) => { this.data = e.target.value; };
                this.wrapper.appendChild(input);
                return this.wrapper;
            }
            save() { return { formula: this.data }; }
        }

        class VizTool {
            static get toolbox() { return { title: 'Visualisasi', icon: '<i class="bx bx-shape-polygon"></i>' }; }
            constructor({data}) { 
                this.data = {
                    title: data.title || '',
                    footer: data.footer || '',
                    elements: data.elements || []
                };
            }

            render() {
                this.wrapper = document.createElement('div');
                this.wrapper.className = 'p-8 bg-white dark:bg-slate-900 rounded-[2.5rem] border-2 border-amber-200 dark:border-amber-500/20 my-6 shadow-xl';
                this.renderUI();
                return this.wrapper;
            }

            renderUI() {
                this.wrapper.innerHTML = '';
                
                // Header
                const header = document.createElement('div');
                header.className = 'flex items-center justify-between mb-8 pb-4 border-b border-amber-50 dark:border-amber-900/20';
                header.innerHTML = `<div class="flex items-center space-x-3"><div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 rounded-xl flex items-center justify-center text-amber-600"><i class="bx bx-shape-polygon text-2xl"></i></div><div><span class="block text-[10px] font-black uppercase tracking-[0.2em] text-amber-500">Visual Designer</span><span class="block text-sm font-bold text-slate-700 dark:text-slate-200">Konfigurasi Grafik Lapis</span></div></div>`;
                this.wrapper.appendChild(header);

                // Preview Box
                const preview = document.createElement('div');
                preview.className = 'mb-8 bg-slate-50 dark:bg-black/20 p-6 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-white/5 flex flex-col items-center';
                preview.innerHTML = `<span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-4 italic">Live Preview (Canvas 200x120)</span><div class="viz-preview-box w-full max-w-[320px] aspect-[200/120] bg-white dark:bg-slate-800 rounded-2xl shadow-inner border border-slate-100 dark:border-white/5 flex items-center justify-center overflow-hidden"></div>`;
                this.wrapper.appendChild(preview);

                // Global Config
                const infoGrid = document.createElement('div');
                infoGrid.className = 'grid grid-cols-2 gap-6 mb-8';
                infoGrid.innerHTML = `
                    <div><label class="text-[10px] font-black uppercase text-slate-400 block mb-2">Judul (LaTeX)</label><input type="text" class="viz-title w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold p-3" value="${this.data.title}"></div>
                    <div><label class="text-[10px] font-black uppercase text-slate-400 block mb-2">Footer Teks</label><input type="text" class="viz-footer w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold p-3" value="${this.data.footer}"></div>
                `;
                infoGrid.querySelector('.viz-title').oninput = (e) => this.data.title = e.target.value;
                infoGrid.querySelector('.viz-footer').oninput = (e) => this.data.footer = e.target.value;
                this.wrapper.appendChild(infoGrid);

                // Elements Section
                const elementsTitle = document.createElement('p');
                elementsTitle.className = 'text-[10px] font-black uppercase text-slate-400 mb-4 tracking-widest';
                elementsTitle.innerText = 'Daftar Elemen Grafik';
                this.wrapper.appendChild(elementsTitle);

                const list = document.createElement('div');
                list.className = 'space-y-4 mb-8';
                this.data.elements.forEach((el, i) => {
                    list.appendChild(this.renderElementRow(el, i));
                });
                this.wrapper.appendChild(list);

                // Add Element Button
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'w-full py-4 bg-amber-50 dark:bg-amber-900/10 text-amber-600 rounded-[1.5rem] border-2 border-dashed border-amber-200 dark:border-amber-500/20 text-[10px] font-black uppercase tracking-widest hover:bg-amber-100 transition flex items-center justify-center';
                addBtn.innerHTML = `<i class="bx bx-plus-circle text-xl me-2"></i> Tambah Elemen`;
                addBtn.onclick = () => {
                    this.data.elements.push({type: 'curve', coords: {start:{x:20,y:100},mid:{x:60,y:100},end:{x:140,y:20}}, color: '#3b82f6', area: true});
                    this.renderUI();
                };
                this.wrapper.appendChild(addBtn);

                this.updatePreview();
            }

            renderElementRow(el, index) {
                const row = document.createElement('div');
                row.className = 'p-6 bg-slate-50 dark:bg-black/20 rounded-[1.5rem] border-2 border-slate-100 dark:border-white/5 relative';
                
                let html = `<div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white dark:bg-slate-800 rounded-lg flex items-center justify-center shadow-sm text-slate-400 font-black text-xs">#${index+1}</div>
                        <select class="el-type bg-white dark:bg-slate-800 border-none rounded-xl text-[10px] font-black uppercase text-slate-500 py-2 px-4 shadow-sm">
                            <option value="curve" ${el.type === 'curve' ? 'selected' : ''}>Kurva / Garis</option>
                            <option value="point" ${el.type === 'point' ? 'selected' : ''}>Titik / Label</option>
                        </select>
                    </div>
                    <button type="button" class="el-delete text-slate-300 hover:text-red-500 transition"><i class="bx bx-trash text-xl"></i></button>
                </div>`;

                if (el.type === 'curve') {
                    html += `<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        ${this.createCoordInput('Mulai', index, 'start', el.coords.start)}
                        ${this.createCoordInput('Lengkung', index, 'mid', el.coords.mid)}
                        ${this.createCoordInput('Akhir', index, 'end', el.coords.end)}
                    </div>
                    <div class="flex items-center space-x-6 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm">
                        <div class="flex items-center space-x-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase">Warna</label>
                            <input type="color" class="el-color h-8 w-12 rounded bg-transparent" value="${el.color}" data-idx="${index}">
                        </div>
                        <label class="flex items-center text-[10px] font-black text-slate-500 uppercase cursor-pointer">
                            <input type="checkbox" class="el-area me-2 rounded text-amber-500 focus:ring-0" ${el.area ? 'checked' : ''} data-idx="${index}"> Arsir Area
                        </label>
                        <label class="flex items-center text-[10px] font-black text-slate-500 uppercase cursor-pointer">
                            <input type="checkbox" class="el-dashed me-2 rounded text-amber-500 focus:ring-0" ${el.dashed ? 'checked' : ''} data-idx="${index}"> Putus-putus
                        </label>
                    </div>`;
                } else {
                    if(!el.x) Object.assign(el, {x:100, y:50, color:'#ef4444', label:'A'});
                    html += `<div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm">
                        <div><label class="text-[9px] font-black text-slate-400 block mb-1">X</label><input type="number" class="el-x w-full text-xs font-bold" value="${el.x}" data-idx="${index}"></div>
                        <div><label class="text-[9px] font-black text-slate-400 block mb-1">Y</label><input type="number" class="el-y w-full text-xs font-bold" value="${el.y}" data-idx="${index}"></div>
                        <div><label class="text-[9px] font-black text-slate-400 block mb-1">Label</label><input type="text" class="el-label w-full text-xs font-bold" value="${el.label}" data-idx="${index}"></div>
                        <div><label class="text-[9px] font-black text-slate-400 block mb-1">Warna</label><input type="color" class="el-color h-8 w-full" value="${el.color}" data-idx="${index}"></div>
                    </div>`;
                }

                row.innerHTML = html;

                // Listeners
                row.querySelector('.el-type').onchange = (e) => { this.data.elements[index].type = e.target.value; this.renderUI(); };
                row.querySelector('.el-delete').onclick = () => { this.data.elements.splice(index, 1); this.renderUI(); };
                
                row.querySelectorAll('input').forEach(inp => {
                    inp.oninput = (e) => {
                        const targetEl = this.data.elements[index];
                        if (e.target.type === 'checkbox') targetEl[e.target.className.includes('el-area') ? 'area' : 'dashed'] = e.target.checked;
                        else if (e.target.className.includes('coord-val')) {
                            targetEl.coords[e.target.dataset.key][e.target.dataset.axis] = parseInt(e.target.value);
                        } else {
                            const prop = e.target.className.split(' ')[0].replace('el-', '');
                            targetEl[prop] = e.target.type === 'number' ? parseInt(e.target.value) : e.target.value;
                        }
                        this.updatePreview();
                    };
                });

                return row;
            }

            createCoordInput(label, idx, key, val) {
                return `<div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-white/5 text-center">
                    <label class="text-[9px] font-black uppercase text-slate-400 block mb-3">${label}</label>
                    <div class="flex items-center space-x-2">
                        <span class="text-[10px] font-black text-slate-300">X</span>
                        <input type="number" class="coord-val w-full text-xs font-black p-0 border-none focus:ring-0 bg-transparent" data-idx="${idx}" data-key="${key}" data-axis="x" value="${val.x}">
                        <span class="text-[10px] font-black text-slate-300 ms-1">Y</span>
                        <input type="number" class="coord-val w-full text-xs font-black p-0 border-none focus:ring-0 bg-transparent" data-idx="${idx}" data-key="${key}" data-axis="y" value="${val.y}">
                    </div>
                </div>`;
            }

            updatePreview() {
                const box = this.wrapper.querySelector('.viz-preview-box');
                if(!box) return;
                let svg = `<svg viewBox="0 0 200 120" class="w-full h-full p-2 overflow-visible">
                    <line x1="0" y1="100" x2="200" y2="100" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2,2" />
                    <line x1="0" y1="0" x2="0" y2="120" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2,2" />`;
                
                this.data.elements.forEach(el => {
                    if (el.type === 'curve') {
                        const d = `M ${el.coords.start.x} ${el.coords.start.y} Q ${el.coords.mid.x} ${el.coords.mid.y} ${el.coords.end.x} ${el.coords.end.y}`;
                        if(el.area) svg += `<path d="${d} L ${el.coords.end.x} 100 L ${el.coords.start.x} 100 Z" fill="${el.color}" fill-opacity="0.2" />`;
                        svg += `<path d="${d}" fill="transparent" stroke="${el.color}" stroke-width="2.5" stroke-linecap="round" ${el.dashed ? 'stroke-dasharray="4,4"' : ''} />`;
                        el.path = d; el.area_path = `${d} L ${el.coords.end.x} 100 L ${el.coords.start.x} 100 Z`;
                    } else if (el.type === 'point') {
                        svg += `<circle cx="${el.x}" cy="${el.y}" r="3.5" fill="${el.color}" stroke="white" stroke-width="1.5" />`;
                        if(el.label) svg += `<text x="${el.x+5}" y="${el.y-5}" font-size="7" font-weight="bold" fill="${el.color}">${el.label}</text>`;
                    }
                });
                svg += `</svg>`; box.innerHTML = svg;
            }

            save() { return this.data; }
        }

        const editor = new EditorJS({
            holder: 'editorjs',
            tools: { header: Header, list: List, paragraph: Paragraph, math: MathTool, visualization: VizTool },
            placeholder: 'Tulis materi...',
        });

        document.getElementById('slide-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const savedData = await editor.save();
            document.getElementById('content-json').value = JSON.stringify(savedData);
            e.target.submit();
        });
    </script>
</x-app-layout>
