@props(['name', 'value' => '', 'dir' => 'ltr', 'required' => false])
<div class="rich-text-editor" data-rich-text>
    <div class="rich-text-toolbar" role="toolbar" aria-label="Text formatting">
        <button type="button" data-editor-command="bold" title="Bold"><strong>B</strong></button>
        <button type="button" data-editor-command="italic" title="Italic"><em>I</em></button>
        <button type="button" data-editor-command="underline" title="Underline"><u>U</u></button>
        <button type="button" data-editor-block="h2">H2</button>
        <button type="button" data-editor-block="h3">H3</button>
        <button type="button" data-editor-command="insertUnorderedList" title="Bullet list">Bullets</button>
        <button type="button" data-editor-command="insertOrderedList" title="Numbered list">Numbers</button>
        <button type="button" data-editor-block="blockquote">Quote</button>
        <button type="button" data-editor-link>Link</button>
        <button type="button" data-editor-command="removeFormat">Clear</button>
    </div>
    <div class="rich-text-surface" contenteditable="true" dir="{{ $dir }}" data-editor-surface>{!! $value !!}</div>
    <textarea name="{{ $name }}" hidden data-editor-input>{{ $value }}</textarea>
</div>
