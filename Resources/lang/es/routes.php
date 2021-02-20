<?php

return [
    
    'documents' => [
      'index' => [
        'publicDocuments' => "documentos/publicos",
        'privateDocuments' => "documentos/privados",
      ],
      
      'show' => [
        'document' => 'documentos/descarga/{documentId}',
        'documentByKey' => 'documentos/descarga/{documentId}/{documentKey}',
      ]
    ]
    
];
