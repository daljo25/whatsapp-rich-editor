<div wire:ignore>
    <textarea id="wa-editor-{{ $getId() }}">{{ $getState() }}</textarea>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

<script>
let editors = {};

/**
 * Inicializa el editor EasyMDE para un textarea específico.
 */
function initWhatsappEditor(id, statePath) {
    if (editors[id]) return; // Evita reinicializar
    let textarea = document.getElementById(id);
    if (!textarea) return;

    let editor = new EasyMDE({
        element: textarea,
        placeholder: "Escribe tu mensaje...",
        autoDownloadFontAwesome: false,
        spellChecker: false,
        toolbar: [
            "bold", "italic", "strikethrough", "code", "|",
            {
                name: "emoji",
                action: function(editor){
                    let emoji = prompt("Inserta un emoji:");
                    if(emoji) editor.codemirror.replaceSelection(emoji);
                },
                className: "fa fa-smile-o",
                title: "Emoji"
            }
        ]
    });

    // Mantener sincronización con Livewire
    editor.codemirror.on("change", function(){
        @this.set(statePath, editor.value());
    });

    editors[id] = editor;
}

// Inicializa al cargar Livewire
document.addEventListener('livewire:load', function () {
    initWhatsappEditor('wa-editor-{{ $getId() }}', '{{ $getStatePath() }}');
});

// Re-inicializa después de cualquier update de Livewire
document.addEventListener('livewire:update', function () {
    initWhatsappEditor('wa-editor-{{ $getId() }}', '{{ $getStatePath() }}');
});
</script>
@endpush
