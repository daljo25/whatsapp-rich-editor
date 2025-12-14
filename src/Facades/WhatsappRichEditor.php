<?php

namespace Daljo25\WhatsappRichEditor\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Daljo25\WhatsappRichEditor\WhatsappRichEditor
 */
class WhatsappRichEditor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Daljo25\WhatsappRichEditor\WhatsappRichEditor::class;
    }
}
