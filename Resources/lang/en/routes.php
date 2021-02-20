<?php

return [
  
  'documents' => [
    'index' => [
      'publicDocuments' => "documents/public",
      'privateDocuments' => "documents/private",
    ],
    'show' => [
      'document' => 'documents/download/{documentId}',
      'documentByKey' => 'documents/download/{documentId}/{documentKey}',
    ]
  ]
];
