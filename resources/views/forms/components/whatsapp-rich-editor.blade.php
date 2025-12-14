@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $isReadOnly = $isReadOnly();
    $statePath = $getStatePath();
    $rows = $getRows();
    $maxLength = $getMaxLength();
    $minLength = $getMinLength();
    $placeholder = $getPlaceholder();
    $autosize = $isAutosize();
    $showToolbar = $shouldShowToolbar();
    $showCharacterCount = $shouldShowCharacterCount();
    $disableEmojis = $areEmojisDisabled();
    $emojiCategories = $getEmojiCategories();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="whatsappRichEditor({
        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
        maxLength: {{ $maxLength ? $maxLength : 'null' }},
        autosize: {{ $autosize ? 'true' : 'false' }},
    })" x-init="init()" class="relative" wire:ignore
        {{ $attributes->merge($getExtraAttributes())->class(['fi-fo-whatsapp-rich-editor']) }}>
        {{-- Toolbar de formato --}}
        @if ($showToolbar && !$isDisabled && !$isReadOnly)
            <div
                class="flex items-center gap-1 mb-2 p-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800">
                {{-- Botón Negrita --}}
                <button type="button" @click="insertFormat('*')" title="Negrita (*texto*)"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z M6 4v16" />
                    </svg>
                </button>

                {{-- Botón Cursiva --}}
                <button type="button" @click="insertFormat('_')" title="Cursiva (_texto_)"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 4h6M12 4v16m-4 0h6" />
                    </svg>
                </button>

                {{-- Botón Tachado --}}
                <button type="button" @click="insertFormat('~')" title="Tachado (~texto~)"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12h18M8 5h8M7 19h10" />
                    </svg>
                </button>

                {{-- Botón Monoespaciado --}}
                <button type="button" @click="insertFormat('``')" title="Monoespaciado (``texto``)"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </button>

                {{-- Divisor --}}
                <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

                {{-- Botón Emoji --}}
                @if (!$disableEmojis)
                    <button type="button" @click="toggleEmojiPicker()" title="Insertar emoji"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500"
                        :class="{ 'bg-gray-100 dark:bg-gray-700': showEmojiPicker }">
                        <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        {{-- Selector de Emojis --}}
        @if (!$disableEmojis)
            <div x-show="showEmojiPicker" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" @click.away="showEmojiPicker = false"
                class="absolute z-50 w-full sm:w-96 max-w-full mb-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-xl overflow-hidden">
                {{-- Pestañas de categorías --}}
                <div
                    class="flex items-center gap-1 p-2 border-b border-gray-200 dark:border-gray-700 overflow-x-auto scrollbar-thin">
                    @foreach ($emojiCategories as $categoryKey => $category)
                        <button type="button" @click="activeEmojiCategory = '{{ $categoryKey }}'"
                            :class="{
                                'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400': activeEmojiCategory === '{{ $categoryKey }}'
                            }"
                            class="flex-shrink-0 px-3 py-1.5 text-sm font-medium rounded-md
                       hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors whitespace-nowrap"
                            title="{{ $category['label'] }}">
                            {{ explode(' ', $category['label'])[0] }}
                        </button>
                    @endforeach
                </div>

                {{-- Contenido --}}
                <div class="p-3 max-h-64 overflow-y-auto scrollbar-thin">
                    @foreach ($emojiCategories as $categoryKey => $category)
                        {{-- Categoría --}}
                        <div x-show="activeEmojiCategory === '{{ $categoryKey }}'">

                            {{-- Título --}}
                            <h4
                                class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-3 uppercase tracking-wider">
                                {{ $category['label'] }}
                            </h4>

                            {{-- Grid de emojis --}}
                            <div class="emoji-grid grid sm:grid-cols-8 gap-2">
                                @foreach ($category['emojis'] as $emoji)
                                    <button type="button" @click="insertEmoji('{{ $emoji }}')"
                                        class="emoji-btn flex items-center justify-center w-9 h-9 text-2xl
                                   rounded-md cursor-pointer
                                   hover:bg-gray-200 dark:hover:bg-gray-700
                                   transition transform hover:scale-110 active:scale-95"
                                        title="{{ $emoji }}">
                                        {{ $emoji }}
                                    </button>
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        {{-- Textarea principal --}}
        <div class="relative">
            {{-- Textarea principal --}}
            <x-filament::input.wrapper :field="$field">
                <textarea id="{{ $id }}" x-ref="textarea" wire:model="{{ $statePath }}" @input="handleInput()"
                    @if ($isDisabled) disabled @endif @if ($isReadOnly) readonly @endif
                    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
                    @if ($rows) rows="{{ $rows }}" @else rows="3" @endif
                    @if ($maxLength) maxlength="{{ $maxLength }}" @endif class="filament-input block w-full"></textarea>
            </x-filament::input.wrapper>
            {{-- Contador de caracteres --}}
            @if ($showCharacterCount && $maxLength)
                <div
                    class="absolute alaign-right bottom-2 right-2 text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 py-1 rounded">
                    <span x-text="state ? state.length : 0"></span>/<span>{{ $maxLength }}</span>
                </div>
            @endif
        </div>

        {{-- Mensaje de ayuda --}}
        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            <span>Formato: </span>
            <span class="font-medium">*negrita*</span>
            <span class="mx-1">•</span>
            <span class="font-medium">_cursiva_</span>
            <span class="mx-1">•</span>
            <span class="font-medium">~tachado~</span>
            <span class="mx-1">•</span>
            <span class="font-medium">``monoespaciado``</span>
        </div>
    </div>
</x-dynamic-component>

{{-- Script Alpine.js --}}
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('whatsappRichEditor', (config) => ({
                state: config.state,
                maxLength: config.maxLength,
                autosize: config.autosize,
                showEmojiPicker: false,
                activeEmojiCategory: 'smileys',

                init() {
                    // Ajustar altura automáticamente si está habilitado
                    if (this.autosize) {
                        this.adjustHeight();
                    }

                    // Sincronizar el valor inicial
                    if (this.state) {
                        this.$refs.textarea.value = this.state;
                    }

                    // Watch para cambios en el estado
                    this.$watch('state', (value) => {
                        if (this.$refs.textarea.value !== value) {
                            this.$refs.textarea.value = value;
                        }
                        if (this.autosize) {
                            this.adjustHeight();
                        }
                    });
                },

                handleInput() {
                    // Actualizar el estado
                    this.state = this.$refs.textarea.value;

                    // Ajustar altura si está habilitado
                    if (this.autosize) {
                        this.adjustHeight();
                    }
                },

                adjustHeight() {
                    const textarea = this.$refs.textarea;
                    if (textarea) {
                        textarea.style.height = 'auto';
                        textarea.style.height = textarea.scrollHeight + 'px';
                    }
                },

                /**
                 * Inserta formato WhatsApp alrededor del texto seleccionado
                 */
                insertFormat(symbol) {
                    const textarea = this.$refs.textarea;
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const selectedText = textarea.value.substring(start, end);
                    const beforeText = textarea.value.substring(0, start);
                    const afterText = textarea.value.substring(end);

                    let newText;
                    let newCursorPos;

                    if (selectedText) {
                        // Hay texto seleccionado
                        newText = beforeText + symbol + selectedText + symbol + afterText;
                        newCursorPos = end + (symbol.length * 2);
                    } else {
                        // No hay texto seleccionado, insertar los símbolos
                        newText = beforeText + symbol + symbol + afterText;
                        newCursorPos = start + symbol.length;
                    }

                    // Actualizar el valor
                    this.state = newText;
                    textarea.value = newText;

                    // Restaurar el foco y la posición del cursor
                    this.$nextTick(() => {
                        textarea.focus();
                        textarea.setSelectionRange(newCursorPos, newCursorPos);

                        // Ajustar altura si está habilitado
                        if (this.autosize) {
                            this.adjustHeight();
                        }

                        // Disparar evento de input para Livewire
                        textarea.dispatchEvent(new Event('input'));
                    });
                },

                /**
                 * Inserta un emoji en la posición del cursor
                 */
                insertEmoji(emoji) {
                    const textarea = this.$refs.textarea;
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const beforeText = textarea.value.substring(0, start);
                    const afterText = textarea.value.substring(end);

                    // Insertar el emoji
                    const newText = beforeText + emoji + afterText;
                    const newCursorPos = start + emoji.length;

                    // Actualizar el valor
                    this.state = newText;
                    textarea.value = newText;

                    // Restaurar el foco y la posición del cursor
                    this.$nextTick(() => {
                        textarea.focus();
                        textarea.setSelectionRange(newCursorPos, newCursorPos);

                        // Ajustar altura si está habilitado
                        if (this.autosize) {
                            this.adjustHeight();
                        }

                        // Disparar evento de input para Livewire
                        textarea.dispatchEvent(new Event('input'));
                    });

                    // Cerrar el selector de emojis
                    this.showEmojiPicker = false;
                },

                /**
                 * Toggle del selector de emojis
                 */
                toggleEmojiPicker() {
                    this.showEmojiPicker = !this.showEmojiPicker;
                }
            }));
        });
    </script>
@endpush

{{-- Estilos adicionales para scrollbar personalizado --}}
@push('styles')
    <style>
        /* 🔥 FIX FINAL: Filament rompe grid-template-columns */
        .emoji-grid {
            display: grid !important;
            grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
            gap: 0.5rem;
        }

        @media (min-width: 640px) {
            .emoji-grid {
                grid-template-columns: repeat(8, minmax(0, 1fr)) !important;
            }
        }

        .emoji-grid>button {
            width: auto !important;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush
