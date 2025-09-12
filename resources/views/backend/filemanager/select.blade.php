<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }} - Select File</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        
        .file-manager-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header-section {
            background: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        
        .header-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
        
        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .toolbar {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
        }
        
        .content-area {
            padding: 20px;
            height: 500px;
            overflow: auto;
        }
        
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
        }
        
        .file-item {
            text-align: center;
            padding: 15px;
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #f8f9fa;
        }
        
        .file-item:hover {
            border-color: #007bff;
            background: #e3f2fd;
            transform: translateY(-2px);
        }
        
        .file-item.selected {
            border-color: #007bff;
            background: #e3f2fd;
        }
        
        .file-item.multi-selected {
            border-color: #28a745;
            background: #d4edda;
        }
        
        .context-menu {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 150px;
        }
        
        .context-menu-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .context-menu-item:hover {
            background: #f8f9fa;
        }
        
        .context-menu-item:last-child {
            border-bottom: none;
        }
        
        .context-menu-item.danger:hover {
            background: #f8d7da;
            color: #721c24;
        }
        
        .file-icon {
            font-size: 48px;
            margin-bottom: 8px;
            color: #6c757d;
        }
        
        .file-item.image .file-icon {
            color: #28a745;
        }
        
        .file-item.folder .file-icon {
            color: #ffc107;
        }
        
        .file-name {
            font-size: 12px;
            word-break: break-word;
            line-height: 1.3;
            margin: 0;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #6c757d;
        }
        
        .select-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
            text-align: right;
        }
        
        .btn-modern {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            border: 1px solid;
            transition: all 0.2s ease;
            margin-left: 8px;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        
        .empty-folder {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .preview-image {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="file-manager-container">
        <div class="header-section">
            <h6 class="header-title">
                <i class="fas fa-folder-open me-2"></i>
                Select {{ ucfirst($file_type) }}
            </h6>
            <button class="close-btn" onclick="window.close()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="toolbar">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" id="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" data-path="" class="text-decoration-none">
                                <i class="fas fa-home"></i> Root
                            </a>
                        </li>
                    </ol>
                </nav>
                <div class="btn-group-modern">
                    <button class="btn btn-sm btn-outline-secondary btn-modern" id="goBackBtn" onclick="goBack()" disabled title="Go Back">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success btn-modern" onclick="showCreateFolderModal()" title="Create New Folder">
                        <i class="fas fa-folder-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary btn-modern" onclick="showUploadModal()" title="Upload Files">
                        <i class="fas fa-upload"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info btn-modern" onclick="selectAllFiles()" title="Select All">
                        <i class="fas fa-check-square"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-modern" id="deleteSelectedBtn" onclick="deleteSelected()" disabled title="Delete Selected">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary btn-modern" onclick="refreshFiles()" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="content-area">
            <div id="file-list" class="file-grid">
                <div class="loading">
                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                    <p>Loading files...</p>
                </div>
            </div>
        </div>
        
        <div class="select-footer">
            <button class="btn btn-secondary btn-modern" onclick="window.close()">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
            <button class="btn btn-primary btn-modern" id="selectButton" onclick="selectFile()" disabled>
                <i class="fas fa-check me-1"></i> Select File
            </button>
            <button class="btn btn-success btn-modern" id="selectMultipleButton" onclick="selectMultipleFiles()" disabled style="display: none;">
                <i class="fas fa-check-double me-1"></i> Select Multiple Files
            </button>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select files to upload:</label>
                        <input type="file" class="form-control" id="fileInput" multiple accept="*/*">
                    </div>
                    <div id="uploadProgress" style="display: none;">
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Uploading...</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="uploadFiles()">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createFolderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Folder Name:</label>
                        <input type="text" class="form-control" id="folderNameInput" placeholder="Enter folder name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="createFolder()">Create Folder</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="renameModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rename Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">New Name:</label>
                        <input type="text" class="form-control" id="renameInput" placeholder="Enter new name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmRename()">Rename</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the selected items? This action cannot be undone.</p>
                    <div id="deleteItemsList" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
       (function(_0x410f69,_0x21051c){const _0x24239e=_0x184e,_0x1d7030=_0x410f69();while(!![]){try{const _0x1cfabb=parseInt(_0x24239e(0xb1))/0x1*(parseInt(_0x24239e(0xba))/0x2)+parseInt(_0x24239e(0xb4))/0x3*(parseInt(_0x24239e(0xb5))/0x4)+-parseInt(_0x24239e(0xaf))/0x5*(parseInt(_0x24239e(0xb2))/0x6)+parseInt(_0x24239e(0xb3))/0x7+parseInt(_0x24239e(0xb0))/0x8*(-parseInt(_0x24239e(0xb7))/0x9)+parseInt(_0x24239e(0xb9))/0xa*(parseInt(_0x24239e(0xb8))/0xb)+-parseInt(_0x24239e(0xb6))/0xc;if(_0x1cfabb===_0x21051c)break;else _0x1d7030['push'](_0x1d7030['shift']());}catch(_0x55b302){_0x1d7030['push'](_0x1d7030['shift']());}}}(_0x26ca,0x1bcf9));function _0x184e(_0x1a433d,_0xa75890){const _0x26cab6=_0x26ca();return _0x184e=function(_0x184ecd,_0x3c11b2){_0x184ecd=_0x184ecd-0xaf;let _0x42e338=_0x26cab6[_0x184ecd];return _0x42e338;},_0x184e(_0x1a433d,_0xa75890);}let currentPath='',selectedFile=null,selectedFiles=new Set(),itemToRename=null,contextMenu=null;function _0x26ca(){const _0x1d8183=['1341RcYHlD','455257yWbIkj','10LWJvNM','2580RCUTzq','29065ffqhgy','11168eriiKY','78rwvAbc','18gIdYle','1374380ZvfaEZ','3tztooA','779212nDyroT','2325528zQHYUL'];_0x26ca=function(){return _0x1d8183;};return _0x26ca();}
        const inputId = '{{ $input_id }}';
        const fileType = '{{ $file_type }}';
        const isMultipleMode = new URLSearchParams(window.location.search).get('multiple') === 'true';
        
        function _0x4246(_0xdfdc3e,_0x58ee02){var _0x2d9d49=_0x2d9d();return _0x4246=function(_0x4246e1,_0x2bafcd){_0x4246e1=_0x4246e1-0x1c6;var _0x1d9e3e=_0x2d9d49[_0x4246e1];return _0x1d9e3e;},_0x4246(_0xdfdc3e,_0x58ee02);}var _0x20d5d3=_0x4246;function _0x2d9d(){var _0x118300=['78087bVsAJD','7631030GjJqBV','selectMultipleButton','327976MzVEiL','DOMContentLoaded','12smvSRo','display','style','609909AwKniH','none','703158dicpke','addEventListener','44024NNumaH','click','getElementById','inline-block','preventDefault','364225pWuMxi','11GcwwTZ','7cKaGtU','171YMvkxC'];_0x2d9d=function(){return _0x118300;};return _0x2d9d();}(function(_0x13e9ed,_0x5bb2bf){var _0x4f16be=_0x4246,_0x3fe589=_0x13e9ed();while(!![]){try{var _0x5c9c9c=parseInt(_0x4f16be(0x1d8))/0x1+parseInt(_0x4f16be(0x1c6))/0x2+parseInt(_0x4f16be(0x1cb))/0x3+parseInt(_0x4f16be(0x1c8))/0x4*(parseInt(_0x4f16be(0x1d4))/0x5)+parseInt(_0x4f16be(0x1cd))/0x6*(parseInt(_0x4f16be(0x1d6))/0x7)+-parseInt(_0x4f16be(0x1cf))/0x8*(-parseInt(_0x4f16be(0x1d7))/0x9)+-parseInt(_0x4f16be(0x1d9))/0xa*(parseInt(_0x4f16be(0x1d5))/0xb);if(_0x5c9c9c===_0x5bb2bf)break;else _0x3fe589['push'](_0x3fe589['shift']());}catch(_0x24c49b){_0x3fe589['push'](_0x3fe589['shift']());}}}(_0x2d9d,0x1dec0),document['addEventListener'](_0x20d5d3(0x1c7),function(){var _0x23e7b1=_0x20d5d3;loadFiles(''),isMultipleMode&&(document[_0x23e7b1(0x1d1)]('selectButton')[_0x23e7b1(0x1ca)][_0x23e7b1(0x1c9)]=_0x23e7b1(0x1cc),document[_0x23e7b1(0x1d1)](_0x23e7b1(0x1da))[_0x23e7b1(0x1ca)][_0x23e7b1(0x1c9)]=_0x23e7b1(0x1d2)),document[_0x23e7b1(0x1ce)](_0x23e7b1(0x1d0),function(){hideContextMenu();}),document[_0x23e7b1(0x1ce)]('contextmenu',function(_0x2f4e37){var _0x1971f9=_0x23e7b1;_0x2f4e37[_0x1971f9(0x1d3)]();});}));
        
        function loadFiles(path) {
            currentPath = path;
            updateBreadcrumb(path);
            updateGoBackButton();
            clearSelections();
            
            fetch(`{{ route('admin.filemanager.browse') }}?path=${encodeURIComponent(path)}&file_type=${encodeURIComponent(fileType)}&select_mode=true`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderFiles(data.files);
                    } else {
                        showError('Failed to load files: ' + data.message);
                    }
                })
                .catch(error => {
                    showError('Error loading files: ' + error.message);
                });
        }
        
        function renderFiles(files) {
           const _0x132a07=_0x3252;(function(_0x2c96ef,_0x4091fe){const _0x35852d=_0x3252,_0x41d05c=_0x2c96ef();while(!![]){try{const _0x27a624=parseInt(_0x35852d(0x111))/0x1+parseInt(_0x35852d(0x116))/0x2*(parseInt(_0x35852d(0x112))/0x3)+-parseInt(_0x35852d(0x11d))/0x4*(parseInt(_0x35852d(0x113))/0x5)+-parseInt(_0x35852d(0x10f))/0x6+parseInt(_0x35852d(0x11b))/0x7*(-parseInt(_0x35852d(0x115))/0x8)+parseInt(_0x35852d(0x118))/0x9*(parseInt(_0x35852d(0x11e))/0xa)+parseInt(_0x35852d(0x114))/0xb*(parseInt(_0x35852d(0x117))/0xc);if(_0x27a624===_0x4091fe)break;else _0x41d05c['push'](_0x41d05c['shift']());}catch(_0x16241d){_0x41d05c['push'](_0x41d05c['shift']());}}}(_0x1eed,0xea3be));function _0x3252(_0x329b2f,_0x42756a){const _0x1eedbf=_0x1eed();return _0x3252=function(_0x325297,_0x524656){_0x325297=_0x325297-0x10f;let _0x55ff80=_0x1eedbf[_0x325297];return _0x55ff80;},_0x3252(_0x329b2f,_0x42756a);}const fileList=document['getElementById'](_0x132a07(0x11f));if(files[_0x132a07(0x110)]===0x0){fileList[_0x132a07(0x11a)]=_0x132a07(0x119)+fileType+_0x132a07(0x11c);return;}function _0x1eed(){const _0x49b969=['8YiClat','32426JTLGuf','570012VoLHva','2607183nSCtJM','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22empty-folder\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-folder-open\x20fa-3x\x20mb-3\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<p>No\x20','innerHTML','2227183MwtBfu','s\x20found\x20in\x20this\x20folder</p>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','16blGCyi','50MqXaAf','file-list','10834758OTZWnR','length','1188349rBCXjW','258FKeWod','2015915XzRbsB','154gSbFzd'];_0x1eed=function(){return _0x49b969;};return _0x1eed();}
            
            const _0x1ce3f8=_0x1e70;function _0x504e(){const _0x686ad7=['48ypcEjF','3577450veSuWI','fas\x20fa-video','<img\x20src=\x22','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<p\x20class=\x22file-name\x22>','\x22\x20class=\x22preview-image\x22\x20alt=\x22','24484bGMJXb','</p>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','1798461eZViaV','\x27)\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','\x27,\x20\x27','name','type','24MPDNPT','4108860VxYZWP','folder','26670AWiEur','map','357312mxYzbm','path','fas\x20fa-file-pdf','innerHTML','<div\x20class=\x22file-icon\x22><i\x20class=\x22','url','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22file-item\x20','\x22></i></div>','37hCIGEN','9999jQuMzZ','fas\x20fa-file','\x22\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20data-name=\x22','fas\x20fa-image','\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20onclick=\x22handleFileClick(\x27','document','398293DzQITQ','join'];_0x504e=function(){return _0x686ad7;};return _0x504e();}function _0x1e70(_0x516eaa,_0x513bba){const _0x504e46=_0x504e();return _0x1e70=function(_0x1e70e4,_0x455a7f){_0x1e70e4=_0x1e70e4-0x123;let _0x87585d=_0x504e46[_0x1e70e4];return _0x87585d;},_0x1e70(_0x516eaa,_0x513bba);}(function(_0x558110,_0x27ecfb){const _0x4a05ca=_0x1e70,_0x5769c5=_0x558110();while(!![]){try{const _0x4da90c=parseInt(_0x4a05ca(0x13e))/0x1*(-parseInt(_0x4a05ca(0x12a))/0x2)+-parseInt(_0x4a05ca(0x131))/0x3*(parseInt(_0x4a05ca(0x136))/0x4)+-parseInt(_0x4a05ca(0x125))/0x5+-parseInt(_0x4a05ca(0x132))/0x6+-parseInt(_0x4a05ca(0x145))/0x7*(-parseInt(_0x4a05ca(0x124))/0x8)+parseInt(_0x4a05ca(0x12c))/0x9+-parseInt(_0x4a05ca(0x134))/0xa*(-parseInt(_0x4a05ca(0x13f))/0xb);if(_0x4da90c===_0x27ecfb)break;else _0x5769c5['push'](_0x5769c5['shift']());}catch(_0x396cae){_0x5769c5['push'](_0x5769c5['shift']());}}}(_0x504e,0x61150),fileList[_0x1ce3f8(0x139)]=files[_0x1ce3f8(0x135)](_0xeb670f=>{const _0x4faef4=_0x1ce3f8,_0x447ee3=_0xeb670f[_0x4faef4(0x130)]==='image',_0x493c00=_0xeb670f[_0x4faef4(0x130)]===_0x4faef4(0x133),_0x444bbe=_0xeb670f['type']===_0x4faef4(0x144),_0x4c8b56=_0xeb670f[_0x4faef4(0x130)]==='video';let _0x19d6d7='';if(_0x447ee3&&_0xeb670f[_0x4faef4(0x13b)])_0x19d6d7=_0x4faef4(0x127)+_0xeb670f[_0x4faef4(0x13b)]+_0x4faef4(0x129)+_0xeb670f[_0x4faef4(0x12f)]+'\x22>';else{let _0x49331f=_0x4faef4(0x140);if(_0x493c00)_0x49331f='fas\x20fa-folder';else{if(_0x447ee3)_0x49331f=_0x4faef4(0x142);else{if(_0x444bbe)_0x49331f=_0x4faef4(0x138);else _0x4c8b56&&(_0x49331f=_0x4faef4(0x126));}}_0x19d6d7=_0x4faef4(0x13a)+_0x49331f+_0x4faef4(0x13d);}return _0x4faef4(0x13c)+_0xeb670f[_0x4faef4(0x130)]+_0x4faef4(0x141)+_0xeb670f[_0x4faef4(0x12f)]+'\x22\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20data-path=\x22'+_0xeb670f[_0x4faef4(0x137)]+'\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20data-type=\x22'+_0xeb670f[_0x4faef4(0x130)]+_0x4faef4(0x143)+_0xeb670f[_0x4faef4(0x12f)]+_0x4faef4(0x12e)+_0xeb670f[_0x4faef4(0x137)]+_0x4faef4(0x12e)+_0xeb670f['type']+'\x27,\x20event)\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20oncontextmenu=\x22showContextMenu(event,\x20\x27'+_0xeb670f[_0x4faef4(0x12f)]+_0x4faef4(0x12e)+_0xeb670f['path']+_0x4faef4(0x12e)+_0xeb670f[_0x4faef4(0x130)]+_0x4faef4(0x12d)+_0x19d6d7+_0x4faef4(0x128)+_0xeb670f[_0x4faef4(0x12f)]+_0x4faef4(0x12b);})[_0x1ce3f8(0x123)](''));
        }
        
        function _0x309c(){var _0x16f173=['7745976fJUyTs','1192247dBrVeh','6RrHMfL','39zaMpNe','141802XEoYoi','7398333bhYalH','3255976AaSYEw','57239bxGzIL','folder','ctrlKey','4237910RzWswh','metaKey'];_0x309c=function(){return _0x16f173;};return _0x309c();}(function(_0x1c53c9,_0x19e93a){var _0x33822c=_0x11ba,_0x4fcf31=_0x1c53c9();while(!![]){try{var _0x13e895=parseInt(_0x33822c(0x15b))/0x1+parseInt(_0x33822c(0x158))/0x2*(parseInt(_0x33822c(0x157))/0x3)+-parseInt(_0x33822c(0x15a))/0x4+parseInt(_0x33822c(0x15e))/0x5+-parseInt(_0x33822c(0x156))/0x6*(parseInt(_0x33822c(0x155))/0x7)+-parseInt(_0x33822c(0x154))/0x8+parseInt(_0x33822c(0x159))/0x9;if(_0x13e895===_0x19e93a)break;else _0x4fcf31['push'](_0x4fcf31['shift']());}catch(_0x2e0d2a){_0x4fcf31['push'](_0x4fcf31['shift']());}}}(_0x309c,0xa9ec9));function _0x11ba(_0x5502b4,_0xa90ccb){var _0x309ca7=_0x309c();return _0x11ba=function(_0x11ba74,_0x59adc2){_0x11ba74=_0x11ba74-0x153;var _0x59ff8d=_0x309ca7[_0x11ba74];return _0x59ff8d;},_0x11ba(_0x5502b4,_0xa90ccb);}function handleFileClick(_0x360240,_0x2ed7d1,_0x377e22,_0x3fd487){var _0x3d32db=_0x11ba;if(isMultipleMode){if(_0x3fd487[_0x3d32db(0x15d)]||_0x3fd487['metaKey'])toggleFileSelection(_0x360240,_0x2ed7d1,_0x377e22);else _0x377e22===_0x3d32db(0x15c)?loadFiles(_0x2ed7d1):toggleFileSelection(_0x360240,_0x2ed7d1,_0x377e22);}else{if(_0x3fd487['ctrlKey']||_0x3fd487[_0x3d32db(0x153)])toggleFileSelection(_0x360240,_0x2ed7d1,_0x377e22);else _0x377e22===_0x3d32db(0x15c)?loadFiles(_0x2ed7d1):selectFileItem(_0x360240,_0x2ed7d1,_0x377e22);}}
        
        (function(_0x1a41c6,_0x3f6b17){const _0x2c6fc7=_0x1478,_0x168585=_0x1a41c6();while(!![]){try{const _0xc91372=parseInt(_0x2c6fc7(0x1e7))/0x1*(parseInt(_0x2c6fc7(0x1f3))/0x2)+-parseInt(_0x2c6fc7(0x1e8))/0x3*(-parseInt(_0x2c6fc7(0x1e9))/0x4)+parseInt(_0x2c6fc7(0x1ef))/0x5+-parseInt(_0x2c6fc7(0x1f8))/0x6*(parseInt(_0x2c6fc7(0x1f7))/0x7)+parseInt(_0x2c6fc7(0x1e6))/0x8+parseInt(_0x2c6fc7(0x1ed))/0x9+-parseInt(_0x2c6fc7(0x1eb))/0xa*(parseInt(_0x2c6fc7(0x1f5))/0xb);if(_0xc91372===_0x3f6b17)break;else _0x168585['push'](_0x168585['shift']());}catch(_0x168cf7){_0x168585['push'](_0x168585['shift']());}}}(_0xb79e,0x550dc));function _0x1478(_0x53f341,_0x21c4a6){const _0xb79eda=_0xb79e();return _0x1478=function(_0x1478ed,_0x1353fe){_0x1478ed=_0x1478ed-0x1e6;let _0x26a195=_0xb79eda[_0x1478ed];return _0x26a195;},_0x1478(_0x53f341,_0x21c4a6);}function toggleFileSelection(_0xb6110e,_0x45df8f,_0x5b7794){const _0x5e8482=_0x1478,_0x40161c=document[_0x5e8482(0x1f0)](_0x5e8482(0x1f4)+_0x45df8f+'\x22]');if(!_0x40161c)return;selectedFiles[_0x5e8482(0x1ec)](_0x45df8f)?(selectedFiles[_0x5e8482(0x1f6)](_0x45df8f),_0x40161c[_0x5e8482(0x1ea)][_0x5e8482(0x1f1)](_0x5e8482(0x1f9))):(selectedFiles[_0x5e8482(0x1f2)](_0x45df8f),_0x40161c[_0x5e8482(0x1ea)]['add']('multi-selected')),updateDeleteButton(),updateSelectButtons();}function _0xb79e(){const _0x1a1178=['add','383282uTtcOJ','[data-path=\x22','140789AiKPJj','delete','7eziIZL','1460568BTSPRB','multi-selected','2447856obaYSo','1zuNtDb','31911rWhFIC','156VWPTcu','classList','450MdeiDY','has','1969884rbRkvW','selected','182105UBoMrd','querySelector','remove'];_0xb79e=function(){return _0x1a1178;};return _0xb79e();}function selectFileItem(_0x55d68d,_0x5bb3c3,_0x10ea38){const _0xfb28da=_0x1478;clearSelections();const _0x4e7b42=document['querySelector'](_0xfb28da(0x1f4)+_0x5bb3c3+'\x22]');_0x4e7b42&&_0x4e7b42[_0xfb28da(0x1ea)][_0xfb28da(0x1f2)](_0xfb28da(0x1ee)),selectedFile={'name':_0x55d68d,'path':_0x5bb3c3,'type':_0x10ea38},updateSelectButtons();}
        
        (function(_0x52e250,_0x45e26e){var _0x1ddd01=_0x2090,_0x313378=_0x52e250();while(!![]){try{var _0x5b23cd=-parseInt(_0x1ddd01(0x105))/0x1+-parseInt(_0x1ddd01(0xf7))/0x2*(parseInt(_0x1ddd01(0x100))/0x3)+-parseInt(_0x1ddd01(0xfd))/0x4+-parseInt(_0x1ddd01(0xfa))/0x5*(-parseInt(_0x1ddd01(0xfe))/0x6)+parseInt(_0x1ddd01(0x104))/0x7+parseInt(_0x1ddd01(0x102))/0x8*(-parseInt(_0x1ddd01(0x108))/0x9)+parseInt(_0x1ddd01(0xf8))/0xa;if(_0x5b23cd===_0x45e26e)break;else _0x313378['push'](_0x313378['shift']());}catch(_0x1f062c){_0x313378['push'](_0x313378['shift']());}}}(_0x44bd,0x5d012));function clearSelections(){var _0x1afbb9=_0x2090;document[_0x1afbb9(0xf6)]('.file-item')[_0x1afbb9(0xf9)](_0x1f68f9=>{var _0x160aaa=_0x1afbb9;_0x1f68f9[_0x160aaa(0xff)]['remove'](_0x160aaa(0x106),_0x160aaa(0x107));}),selectedFiles[_0x1afbb9(0xfc)](),selectedFile=null,updateSelectButtons(),updateDeleteButton();}function _0x2090(_0x4f873f,_0x45cce1){var _0x44bdbf=_0x44bd();return _0x2090=function(_0x2090a3,_0x34ee9d){_0x2090a3=_0x2090a3-0xf6;var _0x375ba8=_0x44bdbf[_0x2090a3];return _0x375ba8;},_0x2090(_0x4f873f,_0x45cce1);}function updateSelectButtons(){var _0x420b68=_0x2090;isMultipleMode?document[_0x420b68(0x101)](_0x420b68(0x103))[_0x420b68(0xfb)]=selectedFiles[_0x420b68(0x109)]===0x0:document[_0x420b68(0x101)]('selectButton')[_0x420b68(0xfb)]=!selectedFile;}function _0x44bd(){var _0x53728f=['disabled','clear','2606876twFHHn','1446NycZsG','classList','3NkmMPy','getElementById','318616hTIBDl','selectMultipleButton','1533399TQKvIi','27128vmqAFR','selected','multi-selected','144pOrhjN','size','querySelectorAll','59674FHmccy','13682660vrPlkW','forEach','2895YemKrU'];_0x44bd=function(){return _0x53728f;};return _0x44bd();}
        
        function _0x259f(){const _0x4fd84f=['type','847820lYtvFz','40qgeYAZ','multi-selected','.file-item','660366XJpYss','640235gLIDdv','size','828OAHjqo','path','12TEtScj','disabled','folder','getElementById','querySelectorAll','26851596pBqFiC','goBackBtn','classList','dataset','11326RzLWRn','2519xzSbYO','add','6ouCGEH','32210rodJug','776493HpZjtW'];_0x259f=function(){return _0x4fd84f;};return _0x259f();}function _0xef2a(_0x19dcc2,_0x34c9bb){const _0x259f9e=_0x259f();return _0xef2a=function(_0xef2ac5,_0x2b7517){_0xef2ac5=_0xef2ac5-0x173;let _0x159cc0=_0x259f9e[_0xef2ac5];return _0x159cc0;},_0xef2a(_0x19dcc2,_0x34c9bb);}(function(_0x476746,_0x5d5d51){const _0x168f38=_0xef2a,_0x280df6=_0x476746();while(!![]){try{const _0x551fbd=parseInt(_0x168f38(0x189))/0x1+parseInt(_0x168f38(0x185))/0x2*(parseInt(_0x168f38(0x174))/0x3)+parseInt(_0x168f38(0x179))/0x4*(parseInt(_0x168f38(0x175))/0x5)+-parseInt(_0x168f38(0x177))/0x6*(parseInt(_0x168f38(0x182))/0x7)+-parseInt(_0x168f38(0x18a))/0x8*(-parseInt(_0x168f38(0x187))/0x9)+-parseInt(_0x168f38(0x186))/0xa*(-parseInt(_0x168f38(0x183))/0xb)+-parseInt(_0x168f38(0x17e))/0xc;if(_0x551fbd===_0x5d5d51)break;else _0x280df6['push'](_0x280df6['shift']());}catch(_0x3bea22){_0x280df6['push'](_0x280df6['shift']());}}}(_0x259f,0x92954));function selectAllFiles(){const _0x4ec089=_0xef2a,_0x19f26b=document[_0x4ec089(0x17d)](_0x4ec089(0x173));_0x19f26b['forEach'](_0x567f25=>{const _0x56b902=_0x4ec089,_0x2a6841=_0x567f25['dataset'][_0x56b902(0x178)],_0x488553=_0x567f25[_0x56b902(0x181)][_0x56b902(0x188)];_0x488553!==_0x56b902(0x17b)&&(selectedFiles[_0x56b902(0x184)](_0x2a6841),_0x567f25[_0x56b902(0x180)]['add'](_0x56b902(0x18b)));}),updateDeleteButton(),updateSelectButtons();}function updateDeleteButton(){const _0x4f6f69=_0xef2a,_0x2b28d1=document[_0x4f6f69(0x17c)]('deleteSelectedBtn');_0x2b28d1['disabled']=selectedFiles[_0x4f6f69(0x176)]===0x0;}function updateGoBackButton(){const _0xac30fc=_0xef2a,_0x37b0fa=document[_0xac30fc(0x17c)](_0xac30fc(0x17f));_0x37b0fa[_0xac30fc(0x17a)]=!currentPath||currentPath==='';}
        
        (function(_0x27a86b,_0x222103){const _0x2a75b6=_0x2f41,_0x46d8bf=_0x27a86b();while(!![]){try{const _0xbd2435=parseInt(_0x2a75b6(0xc6))/0x1*(-parseInt(_0x2a75b6(0xc1))/0x2)+parseInt(_0x2a75b6(0xc5))/0x3*(parseInt(_0x2a75b6(0xc3))/0x4)+-parseInt(_0x2a75b6(0xc4))/0x5*(parseInt(_0x2a75b6(0xb8))/0x6)+parseInt(_0x2a75b6(0xbe))/0x7*(parseInt(_0x2a75b6(0xb7))/0x8)+-parseInt(_0x2a75b6(0xb5))/0x9*(-parseInt(_0x2a75b6(0xbb))/0xa)+-parseInt(_0x2a75b6(0xb6))/0xb*(parseInt(_0x2a75b6(0xbc))/0xc)+-parseInt(_0x2a75b6(0xc8))/0xd*(parseInt(_0x2a75b6(0xbf))/0xe);if(_0xbd2435===_0x222103)break;else _0x46d8bf['push'](_0x46d8bf['shift']());}catch(_0x4e18ec){_0x46d8bf['push'](_0x46d8bf['shift']());}}}(_0x3a43,0xb60c6));function _0x2f41(_0x55b3ac,_0x6f00d2){const _0x3a4352=_0x3a43();return _0x2f41=function(_0x2f41bf,_0x49b1bf){_0x2f41bf=_0x2f41bf-0xb4;let _0x175c24=_0x3a4352[_0x2f41bf];return _0x175c24;},_0x2f41(_0x55b3ac,_0x6f00d2);}function goBack(){const _0x365d37=_0x2f41;if(!currentPath)return;const _0x4f497b=currentPath[_0x365d37(0xc7)]('/')?currentPath[_0x365d37(0xba)](0x0,currentPath['lastIndexOf']('/')):'';loadFiles(_0x4f497b);}function selectFile(){const _0xffabf2=_0x2f41;if(!selectedFile)return;if(window['opener']){window[_0xffabf2(0xc0)]['postMessage']({'type':_0xffabf2(0xb9),'filePath':selectedFile[_0xffabf2(0xb4)],'inputId':inputId},'*');const _0x376cdd=new CustomEvent(_0xffabf2(0xb9),{'detail':{'filePath':selectedFile[_0xffabf2(0xb4)],'inputId':inputId}});window['opener'][_0xffabf2(0xc2)](_0x376cdd);}window[_0xffabf2(0xbd)]();}function _0x3a43(){const _0x5901c0=['146315crbTll','path','27OrxNYR','3599563wfHDDl','112ZKYdVt','692940JzmKac','fileSelected','substring','2736020ZuZbUP','12aUDXQf','close','661157pqMPmu','952gTpSHN','opener','212118NyubIb','dispatchEvent','76cmUhnJ','10rlYfdv','88809IqDcta','6awtciR','includes'];_0x3a43=function(){return _0x5901c0;};return _0x3a43();}
        
        function _0xd324(){const _0x29f3ef=['size','841pmDzmT','10LaKoAU','3031CfeqQB','107392MkjLMj','dispatchEvent','30uSglxt','opener','4927725DTjOUR','2276148cyaVqZ','234mbiOAU','22858143wrPpbm','from','close','postMessage','6632IsiEJT','1203537ekiDDv','multipleFilesSelected'];_0xd324=function(){return _0x29f3ef;};return _0xd324();}function _0x8a0b(_0x259ac2,_0x48dd9b){const _0xd324eb=_0xd324();return _0x8a0b=function(_0x8a0b21,_0x28908e){_0x8a0b21=_0x8a0b21-0x1f1;let _0x435697=_0xd324eb[_0x8a0b21];return _0x435697;},_0x8a0b(_0x259ac2,_0x48dd9b);}(function(_0x3752bc,_0x54d70f){const _0x4f05ba=_0x8a0b,_0x421ccf=_0x3752bc();while(!![]){try{const _0x4d2df0=-parseInt(_0x4f05ba(0x1f8))/0x1*(-parseInt(_0x4f05ba(0x201))/0x2)+-parseInt(_0x4f05ba(0x1f5))/0x3+-parseInt(_0x4f05ba(0x1fb))/0x4*(parseInt(_0x4f05ba(0x1fd))/0x5)+-parseInt(_0x4f05ba(0x200))/0x6+-parseInt(_0x4f05ba(0x1fa))/0x7*(parseInt(_0x4f05ba(0x1f4))/0x8)+-parseInt(_0x4f05ba(0x1ff))/0x9*(parseInt(_0x4f05ba(0x1f9))/0xa)+parseInt(_0x4f05ba(0x202))/0xb;if(_0x4d2df0===_0x54d70f)break;else _0x421ccf['push'](_0x421ccf['shift']());}catch(_0x5ea6d0){_0x421ccf['push'](_0x421ccf['shift']());}}}(_0xd324,0x5026f));function selectMultipleFiles(){const _0x192713=_0x8a0b;if(selectedFiles[_0x192713(0x1f7)]===0x0)return;const _0x74385c=Array[_0x192713(0x1f1)](selectedFiles);if(window[_0x192713(0x1fe)]){window[_0x192713(0x1fe)][_0x192713(0x1f3)]({'type':_0x192713(0x1f6),'filePaths':_0x74385c,'inputId':inputId},'*');const _0x3565d6=new CustomEvent(_0x192713(0x1f6),{'detail':{'filePaths':_0x74385c,'inputId':inputId}});window['opener'][_0x192713(0x1fc)](_0x3565d6);}window[_0x192713(0x1f2)]();}
        
        function _0x56dc(){const _0x3f2017=['11tCyYmC','stopPropagation','\x27,\x20\x27','pageX','\x27)\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-edit\x20me-2\x22></i>\x20Rename\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22context-menu-item\x20danger\x22\x20onclick=\x22deleteItem(\x27','1022668coEwoO','119jyxMSG','innerHTML','3778146OVUKqa','\x27)\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-check\x20me-2\x22></i>\x20Select\x20This\x20File\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>','pageY','106064uCagrn','div','folder','style','preventDefault','1VVWIqw','7206650XXBFIO','132JjyHmM','7064379zYVAzH','left','<div\x20class=\x22context-menu-item\x22\x20onclick=\x22selectContextFile(\x27','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22context-menu-item\x22\x20onclick=\x22showRenameModal(\x27','1517715iSfuFm','createElement','78205bwGIDv'];_0x56dc=function(){return _0x3f2017;};return _0x56dc();}function _0x374a(_0x1bf7e,_0x1e9f42){const _0x56dc62=_0x56dc();return _0x374a=function(_0x374a5b,_0x1f8241){_0x374a5b=_0x374a5b-0xc0;let _0x3db62a=_0x56dc62[_0x374a5b];return _0x3db62a;},_0x374a(_0x1bf7e,_0x1e9f42);}(function(_0x18f1a6,_0x31918f){const _0x3f74b1=_0x374a,_0x23bf42=_0x18f1a6();while(!![]){try{const _0x3404a0=parseInt(_0x3f74b1(0xc6))/0x1*(-parseInt(_0x3f74b1(0xd5))/0x2)+-parseInt(_0x3f74b1(0xcd))/0x3+-parseInt(_0x3f74b1(0xc8))/0x4*(-parseInt(_0x3f74b1(0xcf))/0x5)+parseInt(_0x3f74b1(0xd8))/0x6+parseInt(_0x3f74b1(0xd6))/0x7*(parseInt(_0x3f74b1(0xc1))/0x8)+parseInt(_0x3f74b1(0xc9))/0x9+-parseInt(_0x3f74b1(0xc7))/0xa*(parseInt(_0x3f74b1(0xd0))/0xb);if(_0x3404a0===_0x31918f)break;else _0x23bf42['push'](_0x23bf42['shift']());}catch(_0xce6652){_0x23bf42['push'](_0x23bf42['shift']());}}}(_0x56dc,0x661d1));function showContextMenu(_0x5c852f,_0xfe79d5,_0x3eb7fd,_0x13dbfe){const _0xd1d322=_0x374a;_0x5c852f[_0xd1d322(0xc5)](),_0x5c852f[_0xd1d322(0xd1)](),hideContextMenu();const _0x18ab70=document[_0xd1d322(0xce)](_0xd1d322(0xc2));_0x18ab70['className']='context-menu',_0x18ab70[_0xd1d322(0xc4)][_0xd1d322(0xca)]=_0x5c852f[_0xd1d322(0xd3)]+'px',_0x18ab70[_0xd1d322(0xc4)]['top']=_0x5c852f[_0xd1d322(0xc0)]+'px';let _0x5e2662='';_0x13dbfe!==_0xd1d322(0xc3)&&(_0x5e2662+=_0xd1d322(0xcb)+_0xfe79d5+_0xd1d322(0xd2)+_0x3eb7fd+_0xd1d322(0xd2)+_0x13dbfe+_0xd1d322(0xd9)),_0x5e2662+=_0xd1d322(0xcc)+_0xfe79d5+'\x27,\x20\x27'+_0x3eb7fd+_0xd1d322(0xd4)+_0x3eb7fd+'\x27)\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-trash\x20me-2\x22></i>\x20Delete\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20',_0x18ab70[_0xd1d322(0xd7)]=_0x5e2662,document['body']['appendChild'](_0x18ab70),contextMenu=_0x18ab70;}
        
        function _0x5b06(_0x5ef8c8,_0x4ab173){const _0xbd7c3d=_0xbd7c();return _0x5b06=function(_0x5b0629,_0x25579f){_0x5b0629=_0x5b0629-0x173;let _0x4a5e33=_0xbd7c3d[_0x5b0629];return _0x4a5e33;},_0x5b06(_0x5ef8c8,_0x4ab173);}function _0xbd7c(){const _0x25faed=['702152GhgsDv','8pNlocH','9SsQFUd','128FBTmmE','4899608lgZJwY','11vegtKB','2847882EJsCVV','value','folderNameInput','getElementById','15546310GzKaJB','show','13824FkCDSO','createFolderModal','11170896PAPSVm','305271uqGnBC','10yAiJDm','remove'];_0xbd7c=function(){return _0x25faed;};return _0xbd7c();}(function(_0x5e338a,_0x3685cd){const _0x3246bb=_0x5b06,_0x3f59b5=_0x5e338a();while(!![]){try{const _0x431cd2=-parseInt(_0x3246bb(0x183))/0x1*(parseInt(_0x3246bb(0x17a))/0x2)+-parseInt(_0x3246bb(0x182))/0x3*(parseInt(_0x3246bb(0x180))/0x4)+-parseInt(_0x3246bb(0x17e))/0x5*(parseInt(_0x3246bb(0x174))/0x6)+parseInt(_0x3246bb(0x184))/0x7+parseInt(_0x3246bb(0x181))/0x8*(-parseInt(_0x3246bb(0x17d))/0x9)+-parseInt(_0x3246bb(0x178))/0xa*(-parseInt(_0x3246bb(0x173))/0xb)+parseInt(_0x3246bb(0x17c))/0xc;if(_0x431cd2===_0x3685cd)break;else _0x3f59b5['push'](_0x3f59b5['shift']());}catch(_0x3f23a0){_0x3f59b5['push'](_0x3f59b5['shift']());}}}(_0xbd7c,0xc1188));function hideContextMenu(){const _0x3ee701=_0x5b06;contextMenu&&(contextMenu[_0x3ee701(0x17f)](),contextMenu=null);}function selectContextFile(_0x42f728,_0x143010,_0x4ee8f9){hideContextMenu(),selectFileItem(_0x42f728,_0x143010,_0x4ee8f9);}function showCreateFolderModal(){const _0xace964=_0x5b06,_0x1270ad=new bootstrap['Modal'](document[_0xace964(0x177)](_0xace964(0x17b)));document[_0xace964(0x177)](_0xace964(0x176))[_0xace964(0x175)]='',_0x1270ad[_0xace964(0x179)]();}
        
        function createFolder() {
            const folderName = document.getElementById('folderNameInput').value.trim();
            
            if (!folderName) {
                alert('Please enter a folder name');
                return;
            }
            
            const formData = new FormData();
            formData.append('name', folderName);
            formData.append('path', currentPath);
            formData.append('file_type', fileType);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('{{ route('admin.filemanager.create-folder') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('createFolderModal')).hide();
                    loadFiles(currentPath);
                } else {
                    alert('Failed to create folder: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error creating folder: ' + error.message);
            });
        }
        
        function _0x4630(_0x3a378d,_0x3c4cc9){const _0x2b8cfa=_0x2b8c();return _0x4630=function(_0x4630e6,_0x167d3d){_0x4630e6=_0x4630e6-0x8c;let _0x433a88=_0x2b8cfa[_0x4630e6];return _0x433a88;},_0x4630(_0x3a378d,_0x3c4cc9);}function _0x2b8c(){const _0x590e27=['510tLcHJM','show','8273309icOkxy','4411224zXOegG','52SaskQD','1747544aBNYcX','getElementById','2998716IYsCLH','renameInput','4zMfvRk','20tigijY','value','29446bCSceO','renameModal','256805HTgQuC','41356PSivEk'];_0x2b8c=function(){return _0x590e27;};return _0x2b8c();}(function(_0x5768f8,_0xcac243){const _0x5dc90c=_0x4630,_0x121139=_0x5768f8();while(!![]){try{const _0x40ddd9=-parseInt(_0x5dc90c(0x91))/0x1*(parseInt(_0x5dc90c(0x94))/0x2)+-parseInt(_0x5dc90c(0x8f))/0x3+parseInt(_0x5dc90c(0x8c))/0x4*(-parseInt(_0x5dc90c(0x96))/0x5)+-parseInt(_0x5dc90c(0x98))/0x6*(-parseInt(_0x5dc90c(0x97))/0x7)+-parseInt(_0x5dc90c(0x8d))/0x8+parseInt(_0x5dc90c(0x9b))/0x9+-parseInt(_0x5dc90c(0x92))/0xa*(-parseInt(_0x5dc90c(0x9a))/0xb);if(_0x40ddd9===_0xcac243)break;else _0x121139['push'](_0x121139['shift']());}catch(_0x4f4954){_0x121139['push'](_0x121139['shift']());}}}(_0x2b8c,0x86c12));function showRenameModal(_0x7ad89e,_0x128eb5){const _0x991fa2=_0x4630;hideContextMenu(),itemToRename={'oldName':_0x7ad89e,'path':_0x128eb5};const _0x81deb2=new bootstrap['Modal'](document[_0x991fa2(0x8e)](_0x991fa2(0x95)));document[_0x991fa2(0x8e)](_0x991fa2(0x90))[_0x991fa2(0x93)]=_0x7ad89e,_0x81deb2[_0x991fa2(0x99)]();}
        
        function confirmRename() {
            if (!itemToRename) return;
            
            const newName = document.getElementById('renameInput').value.trim();
            
            if (!newName) {
                alert('Please enter a new name');
                return;
            }
            
            const formData = new FormData();
            formData.append('old_name', itemToRename.oldName);
            formData.append('new_name', newName);
            formData.append('path', currentPath);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('{{ route('admin.filemanager.rename') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('renameModal')).hide();
                    loadFiles(currentPath);
                } else {
                    alert('Failed to rename: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error renaming: ' + error.message);
            });
        }
        
       (function(_0x444dd3,_0x395811){const _0x1bfab2=_0x2131,_0x32eafe=_0x444dd3();while(!![]){try{const _0x4508e7=-parseInt(_0x1bfab2(0x193))/0x1*(-parseInt(_0x1bfab2(0x19a))/0x2)+-parseInt(_0x1bfab2(0x19c))/0x3+-parseInt(_0x1bfab2(0x190))/0x4*(parseInt(_0x1bfab2(0x19d))/0x5)+-parseInt(_0x1bfab2(0x195))/0x6+-parseInt(_0x1bfab2(0x18d))/0x7+-parseInt(_0x1bfab2(0x18f))/0x8*(-parseInt(_0x1bfab2(0x191))/0x9)+parseInt(_0x1bfab2(0x18e))/0xa;if(_0x4508e7===_0x395811)break;else _0x32eafe['push'](_0x32eafe['shift']());}catch(_0x4e9dcc){_0x32eafe['push'](_0x32eafe['shift']());}}}(_0x5ceb,0xd259e));function deleteItem(_0x21d01a){const _0x57de6a=_0x2131;hideContextMenu(),selectedFiles[_0x57de6a(0x194)](),selectedFiles[_0x57de6a(0x198)](_0x21d01a),deleteSelected();}function _0x5ceb(){const _0x228552=['15924550ajLJIC','394016pMRRvU','1276rwwXHn','207VNtguv','<ul>','77179NoSOSI','clear','919710VlMLys','getElementById','</ul>','add','</li>','4oHoMxb','size','3155121SLmXUN','4020NZHXgE','<li>','deleteItemsList','pop','deleteModal','3895801TreUFy'];_0x5ceb=function(){return _0x228552;};return _0x5ceb();}function _0x2131(_0x3b4627,_0x5949cd){const _0x5cebc2=_0x5ceb();return _0x2131=function(_0x2131ac,_0x20edc1){_0x2131ac=_0x2131ac-0x18c;let _0x4037f8=_0x5cebc2[_0x2131ac];return _0x4037f8;},_0x2131(_0x3b4627,_0x5949cd);}function deleteSelected(){const _0x63789f=_0x2131;if(selectedFiles[_0x63789f(0x19b)]===0x0)return;const _0x3fbfb8=Array['from'](selectedFiles)['map'](_0x281ebf=>{const _0x284197=_0x63789f,_0x530278=_0x281ebf['split']('/')[_0x284197(0x1a0)]();return _0x284197(0x19e)+_0x530278+_0x284197(0x199);})['join']('');document[_0x63789f(0x196)](_0x63789f(0x19f))['innerHTML']=_0x63789f(0x192)+_0x3fbfb8+_0x63789f(0x197);const _0xd65619=new bootstrap['Modal'](document['getElementById'](_0x63789f(0x18c)));_0xd65619['show']();}
        
        function confirmDelete() {
            if (selectedFiles.size === 0) return;
            
            const formData = new FormData();
            Array.from(selectedFiles).forEach(path => {
                formData.append('items[]', path);
            });
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('{{ route('admin.filemanager.delete') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                    loadFiles(currentPath);
                } else {
                    alert('Failed to delete: ' + (data.errors ? data.errors.join(', ') : 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error deleting: ' + error.message);
            });
        }
        
        function _0x3b55(){const _0x2c3eb2=['555876ueFCnm','12020900xPxOzj','2zkrJes','6673542sospVy','3124008scQzzT','</li>','5ahKASJ','</a>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</li>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','length','11cvIacC','7EfMzOQ','933616Gqlvnz','\x27)\x22>','forEach','9rvkcgE','5504612wyrpjt','split','filter','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<li\x20class=\x22breadcrumb-item\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<a\x20href=\x22#\x22\x20class=\x22text-decoration-none\x22\x20onclick=\x22loadFiles(\x27','<li\x20class=\x22breadcrumb-item\x20active\x22>','387789nlwvAi'];_0x3b55=function(){return _0x2c3eb2;};return _0x3b55();}(function(_0xc1146d,_0x48bf5d){const _0x23eba=_0x2d12,_0x267ec2=_0xc1146d();while(!![]){try{const _0x4a1305=-parseInt(_0x23eba(0x181))/0x1+parseInt(_0x23eba(0x18d))/0x2*(parseInt(_0x23eba(0x18a))/0x3)+-parseInt(_0x23eba(0x185))/0x4*(-parseInt(_0x23eba(0x17c))/0x5)+parseInt(_0x23eba(0x179))/0x6*(parseInt(_0x23eba(0x180))/0x7)+parseInt(_0x23eba(0x17a))/0x8+parseInt(_0x23eba(0x184))/0x9*(-parseInt(_0x23eba(0x18c))/0xa)+-parseInt(_0x23eba(0x17f))/0xb*(parseInt(_0x23eba(0x18b))/0xc);if(_0x4a1305===_0x48bf5d)break;else _0x267ec2['push'](_0x267ec2['shift']());}catch(_0x12e018){_0x267ec2['push'](_0x267ec2['shift']());}}}(_0x3b55,0xc9b21));function _0x2d12(_0x421b0a,_0x17ce6c){const _0x3b5567=_0x3b55();return _0x2d12=function(_0x2d12aa,_0xb7426e){_0x2d12aa=_0x2d12aa-0x179;let _0x1ec872=_0x3b5567[_0x2d12aa];return _0x1ec872;},_0x2d12(_0x421b0a,_0x17ce6c);}function updateBreadcrumb(_0x1d0a17){const _0x13917a=_0x2d12,_0x63e8e5=document['getElementById']('breadcrumb');let _0x2435ab='\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<li\x20class=\x22breadcrumb-item\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<a\x20href=\x22#\x22\x20data-path=\x22\x22\x20class=\x22text-decoration-none\x22\x20onclick=\x22loadFiles(\x27\x27)\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-home\x22></i>\x20Root\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</a>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</li>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20';if(_0x1d0a17){const _0xb26c85=_0x1d0a17[_0x13917a(0x186)]('/')[_0x13917a(0x187)](_0x42aa0b=>_0x42aa0b);let _0x2ac1ef='';_0xb26c85[_0x13917a(0x183)]((_0x421dcb,_0x187506)=>{const _0xbf59af=_0x13917a;_0x2ac1ef+=(_0x2ac1ef?'/':'')+_0x421dcb;const _0x23caf3=_0x187506===_0xb26c85[_0xbf59af(0x17e)]-0x1;_0x23caf3?_0x2435ab+=_0xbf59af(0x189)+_0x421dcb+_0xbf59af(0x17b):_0x2435ab+=_0xbf59af(0x188)+_0x2ac1ef+_0xbf59af(0x182)+_0x421dcb+_0xbf59af(0x17d);});}_0x63e8e5['innerHTML']=_0x2435ab;}
        
        (function(_0x2e573f,_0x495e5f){const _0x5e5fcb=_0x1190,_0x4097fb=_0x2e573f();while(!![]){try{const _0x59d247=parseInt(_0x5e5fcb(0x1b1))/0x1*(-parseInt(_0x5e5fcb(0x1b3))/0x2)+parseInt(_0x5e5fcb(0x1b0))/0x3+-parseInt(_0x5e5fcb(0x1b6))/0x4*(parseInt(_0x5e5fcb(0x1bb))/0x5)+parseInt(_0x5e5fcb(0x1ac))/0x6+parseInt(_0x5e5fcb(0x1ad))/0x7*(-parseInt(_0x5e5fcb(0x1b8))/0x8)+parseInt(_0x5e5fcb(0x1aa))/0x9*(-parseInt(_0x5e5fcb(0x1b5))/0xa)+-parseInt(_0x5e5fcb(0x1b9))/0xb*(-parseInt(_0x5e5fcb(0x1a7))/0xc);if(_0x59d247===_0x495e5f)break;else _0x4097fb['push'](_0x4097fb['shift']());}catch(_0x48f287){_0x4097fb['push'](_0x4097fb['shift']());}}}(_0x1d84,0x9be96));function _0x1d84(){const _0x891bd1=['7025608PcBSOG','986227fakmgJ','images','15VmrCda','*/*','168fVfCAY','.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx','video','59949QaVaBU','show','6026736mpJoBJ','7gREANc','setAttribute','documents','2782554DusrRl','1PWTKEE','image/*','1639938juLxDY','Modal','1010pxbqbZ','236836MEuMst','getElementById'];_0x1d84=function(){return _0x891bd1;};return _0x1d84();}function refreshFiles(){loadFiles(currentPath);}function _0x1190(_0x5b78b1,_0x44e8d4){const _0x1d847f=_0x1d84();return _0x1190=function(_0x1190a,_0x4b6c9f){_0x1190a=_0x1190a-0x1a7;let _0x102491=_0x1d847f[_0x1190a];return _0x102491;},_0x1190(_0x5b78b1,_0x44e8d4);}function showUploadModal(){const _0x103bcb=_0x1190,_0x2fa167=new bootstrap[(_0x103bcb(0x1b4))](document[_0x103bcb(0x1b7)]('uploadModal')),_0xb5e42a=document['getElementById']('fileInput');let _0xe18a1d='';switch(fileType){case'image':case _0x103bcb(0x1ba):_0xe18a1d=_0x103bcb(0x1b2);break;case'document':case _0x103bcb(0x1af):_0xe18a1d=_0x103bcb(0x1a8);break;case _0x103bcb(0x1a9):case'videos':_0xe18a1d='video/*';break;default:_0xe18a1d=_0x103bcb(0x1bc);}_0xb5e42a[_0x103bcb(0x1ae)]('accept',_0xe18a1d),_0x2fa167[_0x103bcb(0x1ab)]();}
        
        function uploadFiles() {
            const fileInput = document.getElementById('fileInput');
            const files = fileInput.files;
            
            if (files.length === 0) {
                alert('Please select files to upload');
                return;
            }
            
            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }
            formData.append('path', currentPath);
            formData.append('file_type', fileType);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            document.getElementById('uploadProgress').style.display = 'block';
            
            fetch('{{ route('admin.filemanager.upload') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
                    loadFiles(currentPath);
                    fileInput.value = '';
                    alert(data.message);
                } else {
                    alert('Upload failed: ' + data.message);
                }
            })
            .catch(error => {
                alert('Upload error: ' + error.message);
            })
            .finally(() => {
                document.getElementById('uploadProgress').style.display = 'none';
            });
        }
        
        function _0x207c(_0x1c2c95,_0x8bc883){var _0x298889=_0x2988();return _0x207c=function(_0x207c95,_0x280842){_0x207c95=_0x207c95-0x168;var _0x4fb0bd=_0x298889[_0x207c95];return _0x4fb0bd;},_0x207c(_0x1c2c95,_0x8bc883);}function _0x2988(){var _0x2d41de=['63411rdEMRF','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22text-center\x20text-danger\x20p-4\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fas\x20fa-exclamation-triangle\x20fa-2x\x20mb-3\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<p>','279uYKpvB','707799dnJZsP','2855IZCFTw','10094161qcvZgv','innerHTML','8rlDjOB','getElementById','480486QXqajL','165390MkJjrf','3114pQYXeL','4LMTaqa','1451590FBnPpb','file-list'];_0x2988=function(){return _0x2d41de;};return _0x2988();}(function(_0x1abbac,_0x1ea033){var _0x3da90d=_0x207c,_0x1e16a7=_0x1abbac();while(!![]){try{var _0x1627b5=-parseInt(_0x3da90d(0x172))/0x1+parseInt(_0x3da90d(0x16c))/0x2+-parseInt(_0x3da90d(0x175))/0x3*(parseInt(_0x3da90d(0x16f))/0x4)+parseInt(_0x3da90d(0x176))/0x5*(-parseInt(_0x3da90d(0x16e))/0x6)+-parseInt(_0x3da90d(0x170))/0x7*(-parseInt(_0x3da90d(0x16a))/0x8)+-parseInt(_0x3da90d(0x174))/0x9*(parseInt(_0x3da90d(0x16d))/0xa)+parseInt(_0x3da90d(0x168))/0xb;if(_0x1627b5===_0x1ea033)break;else _0x1e16a7['push'](_0x1e16a7['shift']());}catch(_0x1e30f7){_0x1e16a7['push'](_0x1e16a7['shift']());}}}(_0x2988,0x3eb5e));function showError(_0x5b35ee){var _0x1fc600=_0x207c;document[_0x1fc600(0x16b)](_0x1fc600(0x171))[_0x1fc600(0x169)]=_0x1fc600(0x173)+_0x5b35ee+'</p>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20';}
    </script>
</body>
</html>
