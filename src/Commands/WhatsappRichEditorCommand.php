<?php

namespace Daljo25\WhatsappRichEditor\Commands;

use Illuminate\Console\Command;

class WhatsappRichEditorCommand extends Command
{
    public $signature = 'whatsapp-rich-editor';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
