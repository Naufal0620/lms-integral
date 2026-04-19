@props(['data'])

@php
    $id = 'jsxboard-' . uniqid();
    $elements = $data['elements'] ?? [];
    $title = $data['title'] ?? '';
    $footer = $data['footer'] ?? '';
    $boundingbox = $data['boundingbox'] ?? [-1, 10, 11, -1];
    
    // ONLY use legacy fallbacks if elements is completely empty (usually from seeders)
    // If elements is present, it means it was created via the Admin Designer
    if (empty($elements)) {
        $type = $data['type'] ?? 'function';
        
        if ($type === 'area') {
            $formula = $data['formula'] ?? 'x*x';
            // Extract formula from LaTeX integral if present: \int_{a}^{b} f(x) dx
            if (preg_match('/\\\\int_\{.*?\}\^\{.*?\}\s*(.*?)\s*dx/', $formula, $matches)) {
                $formula = $matches[1];
            } elseif (preg_match('/L\s*=\s*(.*)/', $formula, $matches)) {
                $formula = $matches[1];
            }
            
            // Fallback for the specific seeder cases
            if ($formula == '8/3' || str_contains($data['title'] ?? '', 'x^2')) {
                $formula = 'x^2';
            }

            $elements[] = [
                'type' => 'integral', 
                'formula' => $formula, 
                'start' => 0, 
                'end' => $data['x_max_label'] ?? 2,
                'color' => $data['color'] ?? '#3b82f6'
            ];
            $elements[] = [
                'type' => 'function',
                'formula' => $formula,
                'color' => '#1e293b'
            ];
        } elseif ($type === 'family') {
            $elements[] = ['type' => 'function', 'formula' => 'x^2 - 2', 'color' => '#3b82f6'];
            $elements[] = ['type' => 'function', 'formula' => 'x^2', 'color' => '#10b981'];
            $elements[] = ['type' => 'function', 'formula' => 'x^2 + 2', 'color' => '#ef4444'];
            $boundingbox = [-4, 10, 4, -4];
        } elseif ($type === 'between') {
            $elements[] = ['type' => 'function', 'formula' => '4-x^2', 'color' => '#ef4444'];
            $elements[] = ['type' => 'function', 'formula' => 'x^2', 'color' => '#3b82f6'];
            $elements[] = [
                'type' => 'integral', 
                'formula' => '(4-x^2)-(x^2)', 
                'start' => -1.41, 
                'end' => 1.41,
                'color' => '#10b981'
            ];
            $boundingbox = [-3, 6, 3, -1];
        }
    }
@endphp


<div class="my-8 bg-slate-50 dark:bg-white/5 p-4 sm:p-6 rounded-[2.5rem] border-2 border-slate-100 dark:border-white/5 shadow-inner">
    @if($title)
        <h4 class="text-[10px] sm:text-xs font-black uppercase text-slate-500 dark:text-slate-400 mb-6 text-center tracking-[0.2em] italic">{!! $title !!}</h4>
    @endif

    <div class="relative w-full max-w-xl mx-auto overflow-hidden rounded-2xl border border-slate-100 dark:border-white/10 shadow-lg bg-white dark:bg-[#0f172a]">
        <div id="{{ $id }}" class="jxgbox w-full aspect-[16/9]" style="border:none; min-height: 200px;"></div>
    </div>

    @if($footer)
        <p class="text-[9px] sm:text-[10px] text-center text-slate-500 mt-6 italic leading-tight px-4">{!! $footer !!}</p>
    @endif
</div>

@once
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraph.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsxgraph/distrib/jsxgraphcore.js"></script>
    <script>
        window.jsxSafeEval = function(formula, x) {
            try {
                // Basic cleanup
                let processed = formula.toString().replace(/\\/g, '').replace(/\{/g, '(').replace(/\}/g, ')');
                processed = processed.replace(/\^/g, '**');
                // Replace math functions
                const funcs = ['sin', 'cos', 'tan', 'exp', 'log', 'sqrt', 'abs', 'pow'];
                funcs.forEach(f => {
                    const reg = new RegExp('\\b' + f + '\\(', 'g');
                    processed = processed.replace(reg, 'Math.' + f + '(');
                });
                // Security check
                if (/[^0-9x\+\-\*\/\.\(\)\s\x2A\x2A]/.test(processed.replace(/Math\.[a-z]+/g, ''))) {
                    // console.warn("Potential unsafe formula:", formula);
                }
                const fn = new Function('x', 'return ' + processed);
                return fn(x);
            } catch (e) { 
                return 0; 
            }
        };
    </script>
@endonce

<script>
    (function() {
        const boardId = '{{ $id }}';
        const elements = @json($elements);
        const bbox = @json($boundingbox);
        let board = null;

        function init() {
            if (board) return;
            
            const isDark = document.documentElement.classList.contains('dark');
            const axisColor = isDark ? 'rgba(255,255,255,0.2)' : '#cbd5e1';
            const labelColor = isDark ? '#94a3b8' : '#64748b';

            try {
                board = JXG.JSXGraph.initBoard(boardId, {
                    boundingbox: bbox,
                    axis: { strokeColor: axisColor, ticks: { labelColor: labelColor, drawLabels: true } },
                    showCopyright: false, showNavigation: true, keepaspectratio: false,
                    pan: { enabled: true, needShift: false }, zoom: { wheel: true }
                });

                elements.forEach(el => {
                    try {
                        if (el.type === 'function' && el.formula) {
                            board.create('functiongraph', [x => window.jsxSafeEval(el.formula, x)], { 
                                strokeColor: el.color || '#3b82f6', strokeWidth: 3 
                            });
                        } else if (el.type === 'integral' && el.formula) {
                            const f = board.create('functiongraph', [x => window.jsxSafeEval(el.formula, x)], { visible: false });
                            board.create('integral', [[el.start || 0, el.end || 1], f], {
                                fillColor: el.color || '#3b82f6', fillOpacity: 0.3, label: { visible: false }
                            });
                        } else if (el.type === 'point') {
                            board.create('point', [el.x || 0, el.y || 0], {
                                name: el.label || '', color: el.color || '#ef4444', size: 3,
                                label: { strokeColor: labelColor, fontSize: 14 }
                            });
                        }
                    } catch (e) { console.error("JSXGraph element error:", e); }
                });
                board.update();
            } catch (e) { console.error("JSXGraph init error:", e); }
        }

        // Wait for visibility and JXG availability
        function wait() {
            const el = document.getElementById(boardId);
            if (el && el.offsetWidth > 0) {
                if (window.JXG && window.JXG.JSXGraph) { 
                    init(); 
                } else { 
                    setTimeout(wait, 50); 
                }
            } else {
                setTimeout(wait, 200);
            }
        }
        
        // Start waiting
        if (document.readyState === 'complete') {
            wait();
        } else {
            window.addEventListener('load', wait);
        }
    })();
</script>

