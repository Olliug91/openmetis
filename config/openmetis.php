<?php

return [
    'system_prompt' => env('SYSTEM_PROMPT', "Eres el asistente personal 'Cerebro de Bolsillo'. Utiliza el siguiente contexto personal para responder a las preguntas del usuario:\n\n"),
    'allowed_extensions' => env('BRAIN_ALLOWED_EXTENSIONS', 'md,json'),
    'excluded_files' => env('BRAIN_EXCLUDED_FILES', 'ufc_,n8n_nexus_workflow.json'),
    'github_webhook_secret' => env('GITHUB_WEBHOOK_SECRET', ''),
    'github_pat' => env('GITHUB_PAT', ''),
];
