@extends('backend.app')

@section('page_title', translate('File Manager'))

@section('style_files')
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .header-section {
            background: #f8f9fa;
            padding: 25px;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }
        
        .header-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #343a40;
        }
        
        .action-toolbar {
            background: #ffffff;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .btn-modern[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: normal;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }
        
        .btn-modern[title]:hover::before {
            content: '';
            position: absolute;
            bottom: -7px;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-bottom-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            pointer-events: none;
        }
        
        .btn-modern:hover {
            color: white !important;
        }
        
        .btn-modern {
            border-radius: 6px;
            padding: 10px 16px;
            font-weight: 500;
            border: 1px solid;
            transition: all 0.2s ease;
            margin-right: 8px;
            font-size: 14px;
        }
        
        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-secondary.btn-modern:hover,
        .btn-outline-secondary.btn-modern:focus {
            background: #6c757d !important;
            color: #fff !important;
            border-color: #6c757d !important;
        }
        .btn-outline-success.btn-modern:hover,
        .btn-outline-success.btn-modern:focus {
            background: #A9BA9D !important;
            color: #fff !important;
            border-color: #A9BA9D !important;
        }
        .btn-outline-primary.btn-modern:hover,
        .btn-outline-primary.btn-modern:focus {
            background: #512d56 !important;
            color: #fff !important;
            border-color: #512d56 !important;
        }
        .btn-outline-info.btn-modern:hover,
        .btn-outline-info.btn-modern:focus {
            background: #17a2b8 !important;
            color: #fff !important;
            border-color: #17a2b8 !important;
        }
        .btn-outline-danger.btn-modern:hover,
        .btn-outline-danger.btn-modern:focus {
            background: #dc3545 !important;
            color: #fff !important;
            border-color: #dc3545 !important;
        }
        .btn-modern i {
            color: inherit;
            transition: color 0.2s;
        }
        
        .btn-primary-modern {
            background: #007bff;
            color: white;
            border-color: #0056b3;
        }
        
        .btn-primary-modern:hover {
            background: #0056b3;
            border-color: #004085;
            color: white !important;
        }
        
        .btn-success-modern {
            background: #28a745;
            color: white;
            border-color: #1e7e34;
        }
        
        .btn-success-modern:hover {
            background: #1e7e34;
            border-color: #155724;
            color: white !important;
        }
        
        .btn-secondary-modern {
            background: #6c757d;
            color: white;
            border-color: #545b62;
        }
        
        .btn-secondary-modern:hover {
            background: #545b62;
            border-color: #3d4142;
            color: white !important;
        }
        
        .btn-info-modern {
            background: #17a2b8;
            color: white;
            border-color: #117a8b;
        }
        
        .btn-info-modern:hover {
            background: #117a8b;
            border-color: #0c5460;
            color: white !important;
        }
        
        .breadcrumb-modern {
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 20px;
            border: 1px solid #e9ecef;
        }
        
        .breadcrumb-modern .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .breadcrumb-modern .breadcrumb-item a:hover {
            color: #007bff;
            text-decoration: underline;
        }
        
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            padding: 25px;
        }
        
        .file-card {
            background: white;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            max-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
            user-select: none;
            overflow: hidden;
        }
        
        .file-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: #007bff;
        }
        
        .file-card.selected {
            background: #e3f2fd;
            border-color: #2196f3;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }
        
        .file-card .selection-checkbox {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 20px;
            height: 20px;
            background: white;
            border: 2px solid #ddd;
            border-radius: 3px;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        
        .file-card .delete-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 2;
            font-size: 14px;
        }
        
        .file-card .delete-icon:hover {
            background: #c82333;
            transform: scale(1.1);
        }
        
        .file-card:hover .selection-checkbox,
        .file-card.selected .selection-checkbox {
            display: flex;
        }
        
        .file-card:hover .delete-icon {
            display: flex;
        }
        
        .file-card.selected .selection-checkbox {
            background: #2196f3;
            border-color: #2196f3;
            color: white;
        }
        
        .context-menu {
            position: fixed;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            min-width: 160px;
            display: none;
        }
        
        .context-menu-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .context-menu-item:last-child {
            border-bottom: none;
        }
        
        .context-menu-item:hover {
            background: #f8f9fa;
        }
        
        .context-menu-item.danger:hover {
            background: #fee;
            color: #dc3545;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
            border-color: #c82333;
        }
        
        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
        }
        
        .drag-drop-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            margin: 20px;
            transition: all 0.3s ease;
            display: none;
        }
        
        .drag-drop-area.active {
            border-color: #007bff;
            background: #f8f9ff;
        }
        
        .upload-progress {
            margin: 20px;
            display: none;
        }
        
        .file-icon-container {
            flex-shrink: 0;
            text-align: center;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            padding: 0px 0;
        }
        
        .file-icon {
            font-size: 48px;
            margin-bottom: 0;
            display: block;
        }
        
        .folder-icon {
            color: #ffc107;
            font-size: 64px !important;
        }
        
        .file-preview {
            width: 100%;
            height: 120px;
            object-fit: contain;
            border-radius: 6px;
            margin-bottom: 15px;
            border: 2px solid #e9ecef;
            transition: all 0.2s ease;
        }
        
        .file-card:hover .file-preview {
            border-color: #007bff;
            transform: scale(1.05);
        }
        
        .file-name {
            font-weight: 500;
            color: black;
            background: white;
            padding: 5px;
            font-size: 14px;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            line-height: 1.3;
            margin-bottom: 10px;
            padding: 5px;
            min-height: 30px;
            max-height: 60px;
            overflow-y: auto;
            display: block;
            text-align: center;
            width: 100%;
            white-space: normal;
        }
        
        .file-meta {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e9ecef;
            width: 100%;
            flex-shrink: 0;
        }
        
        .file-type-images { color: #28a745; }
        .file-type-documents { color: #007bff; }
        .file-type-videos { color: #dc3545; }
        .file-type-audio { color: #6f42c1; }
        .file-type-code { color: #fd7e14; }
        .file-type-archives { color: #6c757d; }
        .file-type-other { color: #17a2b8; }
        .file-type-default { color: #6c757d; }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            z-index: 1000;
        }
        
        .spinner-modern {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .modal-modern .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .modal-modern .modal-header {
            background: #f8f9fa;
            color: #495057;
            border-radius: 8px 8px 0 0;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .view-toggle {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .toggle-btn {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            background: white;
            color: #495057;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        
        .toggle-btn.active {
            background: #007bff;
            color: white;
            border-color: #0056b3;
        }
        
        .toggle-btn:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }
        
        .toggle-btn.active:hover {
            background: #0056b3;
            border-color: #004085;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 64px;
            color: #ced4da;
            margin-bottom: 20px;
        }
        
        .table td:nth-child(2) {
            vertical-align: middle;
            padding: 15px 8px;
        }
        
        .table td:nth-child(2) i {
            vertical-align: middle;
            font-size: 32px !important;
        }
        
        .table td:nth-child(2) span {
            vertical-align: middle;
            display: inline-block;
            margin-left: 8px;
        }
        
     
        
       
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ translate('File Manager') }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ translate('File Manager') }}</li>
            </ol>
        </div>
    </div>

    <div class="row file-manager mb-4">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="header-section">
                        <h1 class="header-title">
                            <i class="fa fa-folder-open"></i>
                            File Manager by Rohan Ujagare
                        </h1>
                        <p class="mb-0 opacity-75">Manage your files with style and efficiency</p>
                    </div>
                    
                    <div class="action-toolbar">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group-modern">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-modern" id="goBackBtn" disabled title="Go Back">
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success btn-modern" id="createFolderBtn" title="Create New Folder">
                                    <i class="fa fa-folder"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-modern" id="uploadBtn" title="Upload Files">
                                    <i class="fa fa-upload"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-modern" id="selectAllBtn" title="Select All">
                                    <i class="fa fa-check-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-modern" id="deleteSelectedBtn" disabled title="Delete Selected">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-modern" id="refreshBtn" title="Refresh">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                                
                            <div class="view-toggle">
                                <span class="text-muted">View:</span>
                                <button class="toggle-btn active" id="gridViewBtn" data-view="grid">
                                    <i class="fa fa-th"></i>
                                </button>
                                <button class="toggle-btn" id="listViewBtn" data-view="list">
                                    <i class="fa fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-modern" id="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#" data-path="">
                                    <i class="fa fa-home"></i> Root
                                </a>
                            </li>
                        </ol>
                    </nav>

                    <div class="content-area position-relative">
                        <div class="drag-drop-area" id="dragDropArea">
                            <i class="fa fa-cloud-upload" style="font-size: 48px; color: #007bff; margin-bottom: 15px;"></i>
                            <h4>Drag & Drop Files Here</h4>
                            <p class="text-muted">or <a href="#" id="clickToUpload">click to browse</a></p>
                            <input type="file" id="fileInput" multiple style="display: none;">
                        </div>
                        
                        <div class="upload-progress" id="uploadProgress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted" id="uploadStatus">Uploading files...</small>
                            </div>
                        </div>
                        
                        <div id="gridView" class="file-grid">
                        </div>
                        
                        <div id="listView" class="d-none">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30"><input type="checkbox" id="selectAllTable"></th>
                                            <th><i class="fa fa-file"></i> Name</th>
                                            <th width="100"><i class="fa fa-tag"></i> Type</th>
                                            <th width="100"><i class="fa fa-weight-hanging"></i> Size</th>
                                            <th width="150"><i class="fa fa-clock"></i> Modified</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fileTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="loading-overlay" id="loadingIndicator" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-modern"></div>
                                <p class="mt-3 text-muted">Loading files...</p>
                            </div>
                        </div>
                        
                        <div id="emptyState" class="empty-state d-none">
                            <i class="fa fa-folder-open"></i>
                            <h4>This folder is empty</h4>
                            <p class="text-muted">Upload files or create folders to get started</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createFolderModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-folder-plus"></i> Create New Folder
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="createFolderForm">
                        <div class="form-group">
                            <label class="form-label font-weight-bold">
                                <i class="fa fa-tag"></i> Folder Name
                            </label>
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="Enter folder name..." required>
                            <small class="form-text text-muted">Only letters, numbers, spaces, hyphens and underscores are allowed</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-modern btn-success-modern" id="createFolder">
                        <i class="fa fa-plus"></i> Create Folder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-modern" id="renameModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-edit"></i> Rename Item
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="renameForm">
                        <div class="form-group">
                            <label class="form-label font-weight-bold">
                                <i class="fa fa-tag"></i> New Name
                            </label>
                            <input type="text" class="form-control form-control-lg" name="new_name" placeholder="Enter new name..." required>
                            <input type="hidden" name="old_name">
                            <small class="form-text text-muted">Enter the new name for this item</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-modern btn-primary-modern" id="confirmRename">
                        <i class="fa fa-save"></i> Rename
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-modern" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-trash"></i> Delete Items
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Are you sure you want to delete the following items?</p>
                    <ul id="deleteItemsList" class="list-unstyled"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-modern btn-danger" id="confirmDelete">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="contextMenu" class="context-menu">
        <div class="context-menu-item" data-action="rename">
            <i class="fa fa-edit"></i> Rename
        </div>
        <div class="context-menu-item danger" data-action="delete">
            <i class="fa fa-trash"></i> Delete
        </div>
    </div>
@endsection

@section('script')
    <script>
    class TestFileManager {
        constructor() {
            this.currentPath = '';
            this.currentView = 'grid';
            this.currentItems = [];
            this.selectedItems = new Set();
            this.currentContextItem = null;
            this.init();
        }

        init() {
            console.log('TestFileManager initializing...');
            this.bindEvents();
            this.loadFiles();
        }

        bindEvents() {
            // console.log('Binding events...');
           var _0x2363a4=_0xa80e;function _0xa80e(_0x2ccac6,_0x46f296){var _0x133e9a=_0x133e();return _0xa80e=function(_0xa80e4e,_0x4923a4){_0xa80e4e=_0xa80e4e-0x16e;var _0x551e76=_0x133e9a[_0xa80e4e];return _0x551e76;},_0xa80e(_0x2ccac6,_0x46f296);}(function(_0x268b42,_0x16545a){var _0x43c1d0=_0xa80e,_0x3dae26=_0x268b42();while(!![]){try{var _0x27adfb=-parseInt(_0x43c1d0(0x175))/0x1+-parseInt(_0x43c1d0(0x16e))/0x2+-parseInt(_0x43c1d0(0x17b))/0x3*(parseInt(_0x43c1d0(0x170))/0x4)+-parseInt(_0x43c1d0(0x17e))/0x5*(-parseInt(_0x43c1d0(0x179))/0x6)+parseInt(_0x43c1d0(0x174))/0x7+parseInt(_0x43c1d0(0x171))/0x8*(parseInt(_0x43c1d0(0x172))/0x9)+parseInt(_0x43c1d0(0x176))/0xa;if(_0x27adfb===_0x16545a)break;else _0x3dae26['push'](_0x3dae26['shift']());}catch(_0xbfbe7e){_0x3dae26['push'](_0x3dae26['shift']());}}}(_0x133e,0x441dc),$('#goBackBtn')['on'](_0x2363a4(0x173),()=>this[_0x2363a4(0x177)]()),$('#createFolderBtn')['on']('click',()=>$(_0x2363a4(0x17d))['modal'](_0x2363a4(0x178))),$(_0x2363a4(0x17a))['on'](_0x2363a4(0x173),()=>this['loadFiles'](this[_0x2363a4(0x16f)])),$(_0x2363a4(0x17c))['on'](_0x2363a4(0x173),()=>this[_0x2363a4(0x17f)]()));function _0x133e(){var _0x1cd841=['15472EqAjVY','1872LPpsez','click','2240602CZQMzQ','241081XrDDru','3033530ccNHKE','goBack','show','1992ZFopqo','#refreshBtn','201ZBLlGd','#createFolder','#createFolderModal','4700LVaHMN','createFolder','755166dCPaxJ','currentPath','26276jhtpvt'];_0x133e=function(){return _0x1cd841;};return _0x133e();}
            
            function _0x2a22(_0x2924f2,_0x3cd84b){var _0xe27aab=_0xe27a();return _0x2a22=function(_0x2a22e0,_0xd221e4){_0x2a22e0=_0x2a22e0-0x19d;var _0x377767=_0xe27aab[_0x2a22e0];return _0x377767;},_0x2a22(_0x2924f2,_0x3cd84b);}var _0x51cd7=_0x2a22;(function(_0x22bc5c,_0x284d6e){var _0x344d3c=_0x2a22,_0xc0dc62=_0x22bc5c();while(!![]){try{var _0x3d89f9=parseInt(_0x344d3c(0x1a5))/0x1*(-parseInt(_0x344d3c(0x1ab))/0x2)+-parseInt(_0x344d3c(0x1ad))/0x3*(-parseInt(_0x344d3c(0x1a6))/0x4)+-parseInt(_0x344d3c(0x1a1))/0x5*(-parseInt(_0x344d3c(0x1aa))/0x6)+parseInt(_0x344d3c(0x19f))/0x7*(parseInt(_0x344d3c(0x1a2))/0x8)+parseInt(_0x344d3c(0x1a8))/0x9+-parseInt(_0x344d3c(0x1a9))/0xa*(parseInt(_0x344d3c(0x19d))/0xb)+-parseInt(_0x344d3c(0x1ac))/0xc;if(_0x3d89f9===_0x284d6e)break;else _0xc0dc62['push'](_0xc0dc62['shift']());}catch(_0x1d9a57){_0xc0dc62['push'](_0xc0dc62['shift']());}}}(_0xe27a,0x522fb),$(_0x51cd7(0x1a3))['on'](_0x51cd7(0x1a7),()=>$(_0x51cd7(0x1ae))['click']()),$(_0x51cd7(0x1a0))['on'](_0x51cd7(0x1a7),_0x2994dc=>{var _0x13a2e0=_0x51cd7;_0x2994dc[_0x13a2e0(0x19e)](),$(_0x13a2e0(0x1ae))[_0x13a2e0(0x1a7)]();}),$('#fileInput')['on']('change',_0x3deb3d=>this['handleFileUpload'](_0x3deb3d[_0x51cd7(0x1a4)]['files'])));function _0xe27a(){var _0x48bb3e=['click','3107232BLZiOz','10UnFBNq','234KTbvsJ','16662zlzNrM','8790096MjrllG','3dnLvvZ','#fileInput','3714513ZzvdyW','preventDefault','11732xZjybv','#clickToUpload','69105LDqoWI','2096QjKGwj','#uploadBtn','target','9udPPzo','633704KecNZA'];_0xe27a=function(){return _0x48bb3e;};return _0xe27a();}
            
           function _0x4ca9(){const _0x18e6dc=['toggleSelectAll','70OyUVUW','confirmDelete','click','deleteSelected','data','view','#selectAllTable','584gLSYbv','#confirmRename','change','178423sMsmrs','46017oGblJN','319847Uylrrn','#confirmDelete','1566901HnPeSa','688868QLJUcY','19609967hyIrRA','#selectAllBtn','currentTarget','5OjICwZ','563052IcVCEo','12IqPSmH','12rCUDEA','switchView','.toggle-btn','3LDrHdg'];_0x4ca9=function(){return _0x18e6dc;};return _0x4ca9();}const _0x10e9bf=_0x3431;function _0x3431(_0x2b27f4,_0x36af8c){const _0x4ca9c7=_0x4ca9();return _0x3431=function(_0x343182,_0xddd32f){_0x343182=_0x343182-0x19b;let _0x346aff=_0x4ca9c7[_0x343182];return _0x346aff;},_0x3431(_0x2b27f4,_0x36af8c);}(function(_0x177b56,_0x12d96f){const _0x1a577b=_0x3431,_0x1f6cb4=_0x177b56();while(!![]){try{const _0x901616=-parseInt(_0x1a577b(0x1a0))/0x1+parseInt(_0x1a577b(0x1a5))/0x2*(-parseInt(_0x1a577b(0x1af))/0x3)+-parseInt(_0x1a577b(0x1aa))/0x4*(parseInt(_0x1a577b(0x1a9))/0x5)+-parseInt(_0x1a577b(0x1ac))/0x6*(parseInt(_0x1a577b(0x1a4))/0x7)+parseInt(_0x1a577b(0x19d))/0x8*(-parseInt(_0x1a577b(0x1a1))/0x9)+-parseInt(_0x1a577b(0x1b1))/0xa*(-parseInt(_0x1a577b(0x1a2))/0xb)+-parseInt(_0x1a577b(0x1ab))/0xc*(-parseInt(_0x1a577b(0x1a6))/0xd);if(_0x901616===_0x12d96f)break;else _0x1f6cb4['push'](_0x1f6cb4['shift']());}catch(_0x413b0b){_0x1f6cb4['push'](_0x1f6cb4['shift']());}}}(_0x4ca9,0x37873),$(_0x10e9bf(0x1a7))['on'](_0x10e9bf(0x1b3),()=>this['toggleSelectAll']()),$(_0x10e9bf(0x19c))['on'](_0x10e9bf(0x19f),()=>this[_0x10e9bf(0x1b0)]()),$('#deleteSelectedBtn')['on'](_0x10e9bf(0x1b3),()=>this[_0x10e9bf(0x1b4)]()),$(_0x10e9bf(0x19e))['on'](_0x10e9bf(0x1b3),()=>this['confirmRename']()),$(_0x10e9bf(0x1a3))['on']('click',()=>this[_0x10e9bf(0x1b2)]()),$(_0x10e9bf(0x1ae))['on'](_0x10e9bf(0x1b3),_0x13891f=>{const _0x3b0e37=_0x10e9bf,_0x51c42e=$(_0x13891f[_0x3b0e37(0x1a8)])[_0x3b0e37(0x1b5)](_0x3b0e37(0x19b));this[_0x3b0e37(0x1ad)](_0x51c42e);}));

            const _0x167001=_0x5ef7;function _0x5ef7(_0x53e44b,_0x58c4bf){const _0x60b2c5=_0x60b2();return _0x5ef7=function(_0x5ef74b,_0x4d119b){_0x5ef74b=_0x5ef74b-0x191;let _0x55d484=_0x60b2c5[_0x5ef74b];return _0x55d484;},_0x5ef7(_0x53e44b,_0x58c4bf);}(function(_0x4af660,_0x36ee3a){const _0x1a9c82=_0x5ef7,_0x17f3c2=_0x4af660();while(!![]){try{const _0x415f3b=-parseInt(_0x1a9c82(0x1a4))/0x1*(parseInt(_0x1a9c82(0x193))/0x2)+parseInt(_0x1a9c82(0x1a6))/0x3*(parseInt(_0x1a9c82(0x197))/0x4)+parseInt(_0x1a9c82(0x1a1))/0x5+parseInt(_0x1a9c82(0x195))/0x6*(-parseInt(_0x1a9c82(0x1ac))/0x7)+-parseInt(_0x1a9c82(0x196))/0x8+parseInt(_0x1a9c82(0x1ab))/0x9+-parseInt(_0x1a9c82(0x19e))/0xa*(parseInt(_0x1a9c82(0x198))/0xb);if(_0x415f3b===_0x36ee3a)break;else _0x17f3c2['push'](_0x17f3c2['shift']());}catch(_0x586b97){_0x17f3c2['push'](_0x17f3c2['shift']());}}}(_0x60b2,0xd9064),$(document)['on'](_0x167001(0x191),_0x167001(0x19a),_0x44ef09=>{const _0x49e275=_0x167001;_0x44ef09[_0x49e275(0x1a9)]();const _0x40e23f=$(_0x44ef09[_0x49e275(0x1aa)])[_0x49e275(0x19d)]('a')[_0x49e275(0x199)]('path');this[_0x49e275(0x19c)](_0x40e23f);}),$(document)['on'](_0x167001(0x191),'.selection-checkbox,\x20.item-checkbox',_0x155706=>{const _0x161452=_0x167001;_0x155706[_0x161452(0x192)]();const _0x16c6f6=$(_0x155706[_0x161452(0x1a5)])[_0x161452(0x19d)](_0x161452(0x19f));this[_0x161452(0x1a8)](_0x16c6f6);}),$(document)['on'](_0x167001(0x191),_0x167001(0x1a7),_0x1a92dc=>{const _0x59f813=_0x167001;_0x1a92dc[_0x59f813(0x192)]();const _0x40cd11=$(_0x1a92dc[_0x59f813(0x1a5)])[_0x59f813(0x19d)]('.file-card'),_0x2a45d2=_0x40cd11['data'](_0x59f813(0x194)),_0x5b5d2f=_0x40cd11[_0x59f813(0x1a0)](_0x59f813(0x1a2))[_0x59f813(0x1a3)]();this[_0x59f813(0x19b)]([_0x2a45d2]);}));function _0x60b2(){const _0x4ce26d=['799316UIlcqW','5855311IgKssB','data','.breadcrumb\x20a','deleteItems','navigateTo','closest','10hKrqWI','.file-card,\x20tr','find','5774470aPbeiQ','.file-name','text','1bUmQSw','currentTarget','24zbhrtd','.delete-icon','toggleItemSelection','preventDefault','target','8096598kgqCUS','54215BNmflq','click','stopPropagation','2543386YCvrCN','path','282WzRiWV','4769656nLFuOY'];_0x60b2=function(){return _0x4ce26d;};return _0x60b2();}

            function _0x34b3(){const _0x4e91bf=['127852Izkgxr','2281625EbzStO','preventDefault','hasClass','target','216258KWtYON','item-checkbox','navigateTo','closest','2542198jNnAbA','3ejGGdL','path','.file-card,\x20#fileTableBody\x20tr','.selection-checkbox','folder','1149387saTFge','shiftKey','data','3353910DLimym','type','currentTarget','26621136eaOElx','toggleItemSelection'];_0x34b3=function(){return _0x4e91bf;};return _0x34b3();}function _0x1593(_0x1eb801,_0x40cedf){const _0x34b324=_0x34b3();return _0x1593=function(_0x15930f,_0x278956){_0x15930f=_0x15930f-0xd5;let _0x37dc3d=_0x34b324[_0x15930f];return _0x37dc3d;},_0x1593(_0x1eb801,_0x40cedf);}const _0x3fb1b9=_0x1593;(function(_0x3e8c57,_0x35d90f){const _0x1b8a96=_0x1593,_0x2a0b14=_0x3e8c57();while(!![]){try{const _0x473e17=-parseInt(_0x1b8a96(0xdf))/0x1+-parseInt(_0x1b8a96(0xd9))/0x2+parseInt(_0x1b8a96(0xda))/0x3*(parseInt(_0x1b8a96(0xe7))/0x4)+parseInt(_0x1b8a96(0xe8))/0x5+parseInt(_0x1b8a96(0xd5))/0x6+-parseInt(_0x1b8a96(0xe2))/0x7+parseInt(_0x1b8a96(0xe5))/0x8;if(_0x473e17===_0x35d90f)break;else _0x2a0b14['push'](_0x2a0b14['shift']());}catch(_0x282568){_0x2a0b14['push'](_0x2a0b14['shift']());}}}(_0x34b3,0xe8825),$(document)['on']('click',_0x3fb1b9(0xdc),_0x167e75=>{const _0x166a87=_0x3fb1b9;if($(_0x167e75['target'])[_0x166a87(0xea)]('selection-checkbox')||$(_0x167e75[_0x166a87(0xeb)])['hasClass'](_0x166a87(0xd6))||$(_0x167e75[_0x166a87(0xeb)])[_0x166a87(0xd8)](_0x166a87(0xdd))['length']>0x0)return;if(_0x167e75['ctrlKey']||_0x167e75['metaKey'])_0x167e75[_0x166a87(0xe9)](),this[_0x166a87(0xe6)]($(_0x167e75[_0x166a87(0xe4)]));else{if(_0x167e75[_0x166a87(0xe0)])_0x167e75[_0x166a87(0xe9)](),this['rangeSelect']($(_0x167e75['currentTarget']));else{const _0x1c648c=$(_0x167e75[_0x166a87(0xe4)]),_0x33960d=_0x1c648c['data'](_0x166a87(0xdb)),_0x2c7b5d=_0x1c648c[_0x166a87(0xe1)](_0x166a87(0xe3));_0x2c7b5d===_0x166a87(0xde)?this[_0x166a87(0xd7)](_0x33960d):(this['clearSelection'](),this[_0x166a87(0xe6)](_0x1c648c));}}}));

            function _0x5f34(_0x4cc8ce,_0x23aa8c){const _0x1307ff=_0x1307();return _0x5f34=function(_0x5f34aa,_0x788724){_0x5f34aa=_0x5f34aa-0x12a;let _0x1b9c06=_0x1307ff[_0x5f34aa];return _0x1b9c06;},_0x5f34(_0x4cc8ce,_0x23aa8c);}const _0x23b730=_0x5f34;(function(_0x3ae39,_0x584869){const _0x44c11b=_0x5f34,_0x2d1725=_0x3ae39();while(!![]){try{const _0xf976e8=-parseInt(_0x44c11b(0x133))/0x1*(parseInt(_0x44c11b(0x12b))/0x2)+-parseInt(_0x44c11b(0x143))/0x3+-parseInt(_0x44c11b(0x136))/0x4+parseInt(_0x44c11b(0x137))/0x5*(parseInt(_0x44c11b(0x13b))/0x6)+parseInt(_0x44c11b(0x13f))/0x7+parseInt(_0x44c11b(0x12a))/0x8+parseInt(_0x44c11b(0x12c))/0x9;if(_0xf976e8===_0x584869)break;else _0x2d1725['push'](_0x2d1725['shift']());}catch(_0x5610b4){_0x2d1725['push'](_0x2d1725['shift']());}}}(_0x1307,0x9cef7),$(document)['on'](_0x23b730(0x134),_0x23b730(0x139),_0x10fafc=>{const _0x499432=_0x23b730;_0x10fafc[_0x499432(0x130)]();const _0x10c1a0=$(_0x10fafc[_0x499432(0x141)]);this[_0x499432(0x12f)]={'path':_0x10c1a0[_0x499432(0x144)](_0x499432(0x135)),'name':_0x10c1a0[_0x499432(0x13a)](_0x499432(0x12e))[_0x499432(0x132)]()||_0x10c1a0['find'](_0x499432(0x138))[_0x499432(0x132)](),'type':_0x10c1a0[_0x499432(0x144)](_0x499432(0x145))},this['showContextMenu'](_0x10fafc[_0x499432(0x13e)],_0x10fafc[_0x499432(0x147)]);}),$(document)['on'](_0x23b730(0x146),'.context-menu-item',_0x5d9ebc=>{const _0x408011=_0x23b730,_0x234984=$(_0x5d9ebc[_0x408011(0x141)])[_0x408011(0x144)](_0x408011(0x13d));this[_0x408011(0x140)]();if(_0x234984==='rename'&&this[_0x408011(0x12f)])this[_0x408011(0x131)](this[_0x408011(0x12f)]);else _0x234984===_0x408011(0x142)&&this[_0x408011(0x12f)]&&this[_0x408011(0x13c)]([this[_0x408011(0x12f)]['path']]);}),$(document)['on'](_0x23b730(0x146),()=>this[_0x23b730(0x140)]()),this[_0x23b730(0x12d)]());function _0x1307(){const _0x94aa00=['2459527qXlFll','hideContextMenu','currentTarget','delete','2308449zhsLQf','data','type','click','pageY','4110272LlaOed','2vsiFOH','7099182zKZPhT','setupDragAndDrop','.file-name','currentContextItem','preventDefault','showRenameModal','text','348181pitmrP','contextmenu','path','4276704PsqRVA','1405JcLLsS','td:nth-child(2)\x20span','.file-card,\x20#fileTableBody\x20tr','find','25104lBSZQE','deleteItems','action','pageX'];_0x1307=function(){return _0x94aa00;};return _0x1307();}
        }

        setupDragAndDrop() {
           const _0x2eb424=_0x17a4;(function(_0x481043,_0x5a4070){const _0x38149a=_0x17a4,_0x56e21f=_0x481043();while(!![]){try{const _0x5c1884=-parseInt(_0x38149a(0xc8))/0x1+-parseInt(_0x38149a(0xc2))/0x2+parseInt(_0x38149a(0xc5))/0x3*(parseInt(_0x38149a(0xc6))/0x4)+-parseInt(_0x38149a(0xd2))/0x5+parseInt(_0x38149a(0xcf))/0x6*(parseInt(_0x38149a(0xd9))/0x7)+-parseInt(_0x38149a(0xd4))/0x8+-parseInt(_0x38149a(0xc9))/0x9*(-parseInt(_0x38149a(0xd0))/0xa);if(_0x5c1884===_0x5a4070)break;else _0x56e21f['push'](_0x56e21f['shift']());}catch(_0x7cb5ac){_0x56e21f['push'](_0x56e21f['shift']());}}}(_0x293b,0x7516f));const $dropArea=$(_0x2eb424(0xcb)),$contentArea=$('.content-area');function _0x17a4(_0x4269b9,_0x554999){const _0x293bd1=_0x293b();return _0x17a4=function(_0x17a409,_0x2dbee7){_0x17a409=_0x17a409-0xc2;let _0x7d91d5=_0x293bd1[_0x17a409];return _0x7d91d5;},_0x17a4(_0x4269b9,_0x554999);}function _0x293b(){const _0x2e3c06=['dragenter\x20dragover\x20drop','preventDefault','target','1230044RdFdOj','length','types','74127yYgxVQ','4VATAep','removeClass','207117CnwJcY','18MlltnG','dragleave','#dragDropArea','hide','handleFileUpload','includes','107334JOIZrR','9973310aqzbKz','dragenter','2645315ubcGOd','drop','5801920nGeWKx','Files','originalEvent','files','dataTransfer','210AlQxvb'];_0x293b=function(){return _0x2e3c06;};return _0x293b();}$(document)['on'](_0x2eb424(0xda),_0x1408f7=>{const _0x307a8f=_0x2eb424;_0x1408f7[_0x307a8f(0xdb)](),_0x1408f7['stopPropagation']();}),$(document)['on'](_0x2eb424(0xd1),_0x3b49b5=>{const _0x34b388=_0x2eb424;_0x3b49b5[_0x34b388(0xd6)][_0x34b388(0xd8)][_0x34b388(0xc4)][_0x34b388(0xce)](_0x34b388(0xd5))&&$dropArea['show']()['addClass']('active');}),$(document)['on'](_0x2eb424(0xca),_0x4a8326=>{const _0x3e2d9e=_0x2eb424;_0x4a8326[_0x3e2d9e(0xdc)]===document&&$dropArea['removeClass']('active')[_0x3e2d9e(0xcc)]();}),$dropArea['on'](_0x2eb424(0xd3),_0x325c88=>{const _0x3c05db=_0x2eb424;_0x325c88['preventDefault']();const _0x4feff8=_0x325c88[_0x3c05db(0xd6)][_0x3c05db(0xd8)][_0x3c05db(0xd7)];$dropArea[_0x3c05db(0xc7)]('active')[_0x3c05db(0xcc)](),_0x4feff8[_0x3c05db(0xc3)]>0x0&&this[_0x3c05db(0xcd)](_0x4feff8);});
        }

        async handleFileUpload(files) {
            const _0x1190a9=_0xeb42;function _0x32a1(){const _0x9c93a5=['12538341bjTEbw','160517dxAgrB','2501742ndcncn','length','1018556vcUPCj','currentPath','meta[name=\x22csrf-token\x22]','attr','392Wwbwde','2288928UuEaeF','6239016asnqLt','14321JdAqVn','540VzBjuA','98mxIeen','append','10oOsARY'];_0x32a1=function(){return _0x9c93a5;};return _0x32a1();}(function(_0x228b00,_0x27ec52){const _0x3abfe7=_0xeb42,_0x244f91=_0x228b00();while(!![]){try{const _0x5c0843=parseInt(_0x3abfe7(0x1d1))/0x1*(-parseInt(_0x3abfe7(0x1d3))/0x2)+-parseInt(_0x3abfe7(0x1cf))/0x3+-parseInt(_0x3abfe7(0x1d0))/0x4+parseInt(_0x3abfe7(0x1d5))/0x5*(-parseInt(_0x3abfe7(0x1d8))/0x6)+-parseInt(_0x3abfe7(0x1d7))/0x7*(-parseInt(_0x3abfe7(0x1ce))/0x8)+-parseInt(_0x3abfe7(0x1d6))/0x9+parseInt(_0x3abfe7(0x1d2))/0xa*(parseInt(_0x3abfe7(0x1da))/0xb);if(_0x5c0843===_0x27ec52)break;else _0x244f91['push'](_0x244f91['shift']());}catch(_0x11d3f9){_0x244f91['push'](_0x244f91['shift']());}}}(_0x32a1,0xd4f59));if(!files||files[_0x1190a9(0x1d9)]===0x0)return;const formData=new FormData();for(let i=0x0;i<files['length'];i++){formData['append']('files[]',files[i]);}function _0xeb42(_0x4f8130,_0x460048){const _0x32a164=_0x32a1();return _0xeb42=function(_0xeb42ef,_0x24a18f){_0xeb42ef=_0xeb42ef-0x1cb;let _0x56164c=_0x32a164[_0xeb42ef];return _0x56164c;},_0xeb42(_0x4f8130,_0x460048);}formData[_0x1190a9(0x1d4)]('path',this[_0x1190a9(0x1cb)]),formData['append']('_token',$(_0x1190a9(0x1cc))[_0x1190a9(0x1cd)]('content'));

            try {
               function _0x232c(){var _0x48369e=['2330YpSoax','show','.progress-bar','Uploading\x20files...','width','41646VFSAQQ','79633uUFFMr','#uploadProgress','3eZXEXj','294565RFQqgt','#uploadStatus','12bMqDrG','1398369siwKal','12xbMxtZ','2971548uFZGcg','24RxBZEX','27556087FSPLCK','6716763NwEPUb','6nMhzRf','text'];_0x232c=function(){return _0x48369e;};return _0x232c();}var _0x574717=_0x161b;function _0x161b(_0x39854c,_0x1238e6){var _0x232caf=_0x232c();return _0x161b=function(_0x161b70,_0x315e56){_0x161b70=_0x161b70-0xb2;var _0x18573d=_0x232caf[_0x161b70];return _0x18573d;},_0x161b(_0x39854c,_0x1238e6);}(function(_0x594bbc,_0x6d6d31){var _0x3b50c4=_0x161b,_0x3f2046=_0x594bbc();while(!![]){try{var _0x1afa29=-parseInt(_0x3b50c4(0xb5))/0x1*(-parseInt(_0x3b50c4(0xc1))/0x2)+parseInt(_0x3b50c4(0xb7))/0x3*(-parseInt(_0x3b50c4(0xbd))/0x4)+-parseInt(_0x3b50c4(0xb8))/0x5*(parseInt(_0x3b50c4(0xba))/0x6)+parseInt(_0x3b50c4(0xbb))/0x7*(-parseInt(_0x3b50c4(0xbe))/0x8)+parseInt(_0x3b50c4(0xc0))/0x9+-parseInt(_0x3b50c4(0xc3))/0xa*(parseInt(_0x3b50c4(0xb4))/0xb)+parseInt(_0x3b50c4(0xbc))/0xc*(parseInt(_0x3b50c4(0xbf))/0xd);if(_0x1afa29===_0x6d6d31)break;else _0x3f2046['push'](_0x3f2046['shift']());}catch(_0x13f093){_0x3f2046['push'](_0x3f2046['shift']());}}}(_0x232c,0xba381),$(_0x574717(0xb6))[_0x574717(0xc4)](),$(_0x574717(0xc5))['css'](_0x574717(0xb3),'0%'),$(_0x574717(0xb9))[_0x574717(0xc2)](_0x574717(0xb2)));

                const response = await $.ajax({
                    url: '{{ route("admin.filemanager.upload") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                const percentComplete = (evt.loaded / evt.total) * 100;
                                $('.progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    }
                });

                // console.log('Upload response:', response);
                
                const _0x2e4909=_0x1e59;function _0x1e59(_0x29b535,_0xba855a){const _0x3233c2=_0x3233();return _0x1e59=function(_0x1e59e9,_0x9e62f4){_0x1e59e9=_0x1e59e9-0x1bd;let _0x55c234=_0x3233c2[_0x1e59e9];return _0x55c234;},_0x1e59(_0x29b535,_0xba855a);}(function(_0x3fa0c3,_0x478f22){const _0x404f70=_0x1e59,_0x3cd386=_0x3fa0c3();while(!![]){try{const _0x4e2cd3=parseInt(_0x404f70(0x1d3))/0x1+parseInt(_0x404f70(0x1ca))/0x2+-parseInt(_0x404f70(0x1be))/0x3*(-parseInt(_0x404f70(0x1c2))/0x4)+parseInt(_0x404f70(0x1c6))/0x5+-parseInt(_0x404f70(0x1cc))/0x6*(parseInt(_0x404f70(0x1cd))/0x7)+parseInt(_0x404f70(0x1c3))/0x8+parseInt(_0x404f70(0x1c8))/0x9*(-parseInt(_0x404f70(0x1c7))/0xa);if(_0x4e2cd3===_0x478f22)break;else _0x3cd386['push'](_0x3cd386['shift']());}catch(_0x380096){_0x3cd386['push'](_0x3cd386['shift']());}}}(_0x3233,0x502f8));if(response['success']&&response[_0x2e4909(0x1c4)]&&response[_0x2e4909(0x1c4)][_0x2e4909(0x1bd)]>0x0)$(_0x2e4909(0x1d0))[_0x2e4909(0x1cb)](response['message']||response['uploaded'][_0x2e4909(0x1bd)]+_0x2e4909(0x1ce)),response[_0x2e4909(0x1d2)]&&response[_0x2e4909(0x1d2)][_0x2e4909(0x1bd)]>0x0&&setTimeout(()=>{const _0x463f87=_0x2e4909;this[_0x463f87(0x1c9)]('error','Some\x20files\x20failed\x20to\x20upload:\x0a'+response[_0x463f87(0x1d2)]['join']('\x0a'));},0x64),setTimeout(()=>{const _0x3ea3f0=_0x2e4909;$(_0x3ea3f0(0x1d1))[_0x3ea3f0(0x1c5)](),this[_0x3ea3f0(0x1c1)](this['currentPath']);},0x5dc);else{let errorMessage=_0x2e4909(0x1c0);if(response[_0x2e4909(0x1d2)]&&response[_0x2e4909(0x1d2)]['length']>0x0)errorMessage=response['errors'][_0x2e4909(0x1bf)]('\x0a');else response[_0x2e4909(0x1cf)]&&(errorMessage=response[_0x2e4909(0x1cf)]);throw new Error(errorMessage);}function _0x3233(){const _0x1ed668=['20TnFtHV','4192440mqqAZD','uploaded','hide','2327595PCKszl','20RVTmee','3271455hZgyXR','showMessage','76072XxAlxR','text','12bOtSzS','1414973sKEFDD','\x20file(s)\x20uploaded\x20successfully','message','#uploadStatus','#uploadProgress','errors','112123iQIPIR','length','191985CgqhnF','join','Upload\x20failed','loadFiles'];_0x3233=function(){return _0x1ed668;};return _0x3233();}

            } catch (error) {
               function _0x343a(_0x5723cc,_0x24da12){var _0x332dff=_0x332d();return _0x343a=function(_0x343a75,_0xb51eec){_0x343a75=_0x343a75-0xe0;var _0x19f6d7=_0x332dff[_0x343a75];return _0x19f6d7;},_0x343a(_0x5723cc,_0x24da12);}function _0x332d(){var _0xc7c49e=['2051769xkQkJX','Upload\x20failed:\x20','1907157yrTwdF','#uploadProgress','3934015mALxco','error','18098mAhKqi','Upload\x20error:','Unknown\x20error','2660888fdDdcL','#uploadStatus','1mpqktG','16723192tTFeCw','1466790yzIUGd'];_0x332d=function(){return _0xc7c49e;};return _0x332d();}var _0x5c548e=_0x343a;(function(_0xfb8afe,_0x3a3274){var _0x213587=_0x343a,_0x2c32c7=_0xfb8afe();while(!![]){try{var _0x27ec05=-parseInt(_0x213587(0xe8))/0x1*(parseInt(_0x213587(0xe3))/0x2)+-parseInt(_0x213587(0xeb))/0x3+-parseInt(_0x213587(0xe6))/0x4+-parseInt(_0x213587(0xe1))/0x5+parseInt(_0x213587(0xea))/0x6+parseInt(_0x213587(0xed))/0x7+parseInt(_0x213587(0xe9))/0x8;if(_0x27ec05===_0x3a3274)break;else _0x2c32c7['push'](_0x2c32c7['shift']());}catch(_0x503e95){_0x2c32c7['push'](_0x2c32c7['shift']());}}}(_0x332d,0x70dee),console['error'](_0x5c548e(0xe4),error),$(_0x5c548e(0xe7))['text'](_0x5c548e(0xec)+(error['responseJSON']?.[_0x5c548e(0xe2)]||error['message']||_0x5c548e(0xe5))),setTimeout(()=>$(_0x5c548e(0xe0))['hide'](),0xbb8));
            }

            $('#fileInput').val('');
        }

        toggleItemSelection($element) {
            const path = $element.data('path');
            
           function _0x3c21(){var _0x53692d=['5550310uIiykm','addClass','prop','5436ZCuFBi','removeClass','selectedItems','delete','21747392DJdphx','find','add','1534442wajyrK','2084736FBuSnw','html','2043282iiKSLe','2350864leONFC','217RJhOmY','checked','selected'];_0x3c21=function(){return _0x53692d;};return _0x3c21();}function _0x5611(_0xaaed76,_0x3631d2){var _0x3c21f6=_0x3c21();return _0x5611=function(_0x561158,_0x4d141e){_0x561158=_0x561158-0x1ec;var _0x1beafb=_0x3c21f6[_0x561158];return _0x1beafb;},_0x5611(_0xaaed76,_0x3631d2);}var _0x223171=_0x5611;(function(_0x107ccd,_0x54a403){var _0x18d80a=_0x5611,_0x3f4211=_0x107ccd();while(!![]){try{var _0x5c0b73=parseInt(_0x18d80a(0x1fa))/0x1+-parseInt(_0x18d80a(0x1ec))/0x2+-parseInt(_0x18d80a(0x1fd))/0x3+-parseInt(_0x18d80a(0x1fb))/0x4+-parseInt(_0x18d80a(0x1f0))/0x5+parseInt(_0x18d80a(0x1f3))/0x6*(parseInt(_0x18d80a(0x1ed))/0x7)+parseInt(_0x18d80a(0x1f7))/0x8;if(_0x5c0b73===_0x54a403)break;else _0x3f4211['push'](_0x3f4211['shift']());}catch(_0x10928e){_0x3f4211['push'](_0x3f4211['shift']());}}}(_0x3c21,0xc1a5c));this['selectedItems']['has'](path)?(this['selectedItems'][_0x223171(0x1f6)](path),$element[_0x223171(0x1f4)]('selected'),$element['find']('.selection-checkbox')[_0x223171(0x1fc)](''),$element['find']('.item-checkbox')[_0x223171(0x1f2)](_0x223171(0x1ee),![])):(this[_0x223171(0x1f5)][_0x223171(0x1f9)](path),$element[_0x223171(0x1f1)](_0x223171(0x1ef)),$element['find']('.selection-checkbox')[_0x223171(0x1fc)]('<i\x20class=\x22fa\x20fa-check\x22></i>'),$element[_0x223171(0x1f8)]('.item-checkbox')[_0x223171(0x1f2)](_0x223171(0x1ee),!![]));
            
            this.updateSelectionUI();
        }

        clearSelection() {
            this.selectedItems.clear();
           var _0x4de337=_0x2f14;function _0x2f14(_0x574793,_0xaff49c){var _0x9c8ee3=_0x9c8e();return _0x2f14=function(_0x2f14b2,_0xd97077){_0x2f14b2=_0x2f14b2-0x173;var _0x238ed9=_0x9c8ee3[_0x2f14b2];return _0x238ed9;},_0x2f14(_0x574793,_0xaff49c);}(function(_0x13735b,_0x208980){var _0x42f593=_0x2f14,_0x59e018=_0x13735b();while(!![]){try{var _0x33b8cc=-parseInt(_0x42f593(0x17a))/0x1*(-parseInt(_0x42f593(0x17b))/0x2)+parseInt(_0x42f593(0x176))/0x3*(parseInt(_0x42f593(0x182))/0x4)+parseInt(_0x42f593(0x181))/0x5*(parseInt(_0x42f593(0x17f))/0x6)+parseInt(_0x42f593(0x177))/0x7+parseInt(_0x42f593(0x175))/0x8*(parseInt(_0x42f593(0x179))/0x9)+parseInt(_0x42f593(0x174))/0xa*(parseInt(_0x42f593(0x17d))/0xb)+-parseInt(_0x42f593(0x173))/0xc*(parseInt(_0x42f593(0x183))/0xd);if(_0x33b8cc===_0x208980)break;else _0x59e018['push'](_0x59e018['shift']());}catch(_0x3178bf){_0x59e018['push'](_0x59e018['shift']());}}}(_0x9c8e,0x4802e),$('.file-card,\x20#fileTableBody\x20tr')['removeClass'](_0x4de337(0x180)),$('.selection-checkbox')[_0x4de337(0x17c)](''),$('.item-checkbox')[_0x4de337(0x178)](_0x4de337(0x17e),![]));function _0x9c8e(){var _0x29cf9d=['4CVgPZS','825305upcoBP','360IGzHaV','80380qQjrvw','2824PcbkUH','1385421zbETpv','1397270ErdGtH','prop','8613UzFFIu','121885IlhIPT','8IupOMX','html','187XkGaIF','checked','14166bXfQkp','selected','1220UyJtbO'];_0x9c8e=function(){return _0x29cf9d;};return _0x9c8e();}
            this.updateSelectionUI();
        }

        toggleSelectAll() {
            var _0x558331=_0x332b;(function(_0x48ed96,_0x15ce13){var _0x2ff62c=_0x332b,_0x3b5147=_0x48ed96();while(!![]){try{var _0x27c99e=parseInt(_0x2ff62c(0x179))/0x1*(parseInt(_0x2ff62c(0x182))/0x2)+-parseInt(_0x2ff62c(0x177))/0x3*(-parseInt(_0x2ff62c(0x171))/0x4)+parseInt(_0x2ff62c(0x176))/0x5*(parseInt(_0x2ff62c(0x17a))/0x6)+parseInt(_0x2ff62c(0x17d))/0x7*(parseInt(_0x2ff62c(0x174))/0x8)+parseInt(_0x2ff62c(0x181))/0x9+-parseInt(_0x2ff62c(0x16d))/0xa*(parseInt(_0x2ff62c(0x173))/0xb)+-parseInt(_0x2ff62c(0x175))/0xc;if(_0x27c99e===_0x15ce13)break;else _0x3b5147['push'](_0x3b5147['shift']());}catch(_0x4a6309){_0x3b5147['push'](_0x3b5147['shift']());}}}(_0x3625,0xdb66b));function _0x332b(_0x269a15,_0x435cb0){var _0x362589=_0x3625();return _0x332b=function(_0x332bc5,_0x16c82d){_0x332bc5=_0x332bc5-0x16b;var _0x648f69=_0x362589[_0x332bc5];return _0x648f69;},_0x332b(_0x269a15,_0x435cb0);}function _0x3625(){var _0x2de042=['70uzyZci','html','<i\x20class=\x22fa\x20fa-check\x22></i>','size','32PPBAWI','length','1860067jBKuKQ','400oGWPXA','23187180HyIMcK','20815OLgcZO','2481zBmxVa','selected','122jQzImk','510LOqKVo','forEach','addClass','203315tPVNJt','updateSelectionUI','currentItems','clearSelection','8658036XOGCra','20326SxAoTK','add','selectedItems','.file-card,\x20#fileTableBody\x20tr'];_0x3625=function(){return _0x2de042;};return _0x3625();}this[_0x558331(0x16b)][_0x558331(0x170)]===this[_0x558331(0x17f)][_0x558331(0x172)]?this[_0x558331(0x180)]():(this[_0x558331(0x180)](),this[_0x558331(0x17f)][_0x558331(0x17b)](_0x18f131=>{var _0x363f7f=_0x558331;this[_0x363f7f(0x16b)][_0x363f7f(0x183)](_0x18f131['path']);}),$(_0x558331(0x16c))[_0x558331(0x17c)](_0x558331(0x178)),$('.selection-checkbox')[_0x558331(0x16e)](_0x558331(0x16f)),$('.item-checkbox')['prop']('checked',!![]),this[_0x558331(0x17e)]());
        }

        updateSelectionUI() {
            const _0x1907b=_0x4d8e;function _0x1cec(){const _0xada966=['prop','#selectAllBtn','16914xFxFMN','1785xAUMIM','864077hhpeBs','7348488wvMVbE','737wovAST','<i\x20class=\x22fa\x20fa-square\x22></i>\x20Deselect\x20All','#deleteSelectedBtn','4asvtsr','5052249CghAxy','html','483755wUqzIk','indeterminate','2UritwU','checked','size','2695317HVhwbr','selectedItems','229650KOqYwh','#selectAllTable','length'];_0x1cec=function(){return _0xada966;};return _0x1cec();}(function(_0x7f5acc,_0x1a0354){const _0x231ae2=_0x4d8e,_0x4ef9ea=_0x7f5acc();while(!![]){try{const _0x39f596=parseInt(_0x231ae2(0x1df))/0x1+parseInt(_0x231ae2(0x1d3))/0x2*(-parseInt(_0x231ae2(0x1d6))/0x3)+parseInt(_0x231ae2(0x1e4))/0x4*(parseInt(_0x231ae2(0x1e7))/0x5)+parseInt(_0x231ae2(0x1dd))/0x6*(-parseInt(_0x231ae2(0x1de))/0x7)+-parseInt(_0x231ae2(0x1e0))/0x8+parseInt(_0x231ae2(0x1e5))/0x9+parseInt(_0x231ae2(0x1d8))/0xa*(parseInt(_0x231ae2(0x1e1))/0xb);if(_0x39f596===_0x1a0354)break;else _0x4ef9ea['push'](_0x4ef9ea['shift']());}catch(_0x3dda35){_0x4ef9ea['push'](_0x4ef9ea['shift']());}}}(_0x1cec,0x802c7));const selectedCount=this[_0x1907b(0x1d7)][_0x1907b(0x1d5)],totalCount=this['currentItems'][_0x1907b(0x1da)];$(_0x1907b(0x1e3))['prop']('disabled',selectedCount===0x0);function _0x4d8e(_0x27c681,_0x9b9d1){const _0x1cec1d=_0x1cec();return _0x4d8e=function(_0x4d8e23,_0x278a0b){_0x4d8e23=_0x4d8e23-0x1d2;let _0x5d2396=_0x1cec1d[_0x4d8e23];return _0x5d2396;},_0x4d8e(_0x27c681,_0x9b9d1);}if(selectedCount===0x0)$(_0x1907b(0x1dc))[_0x1907b(0x1e6)]('<i\x20class=\x22fa\x20fa-check-square\x22></i>\x20Select\x20All'),$(_0x1907b(0x1d9))[_0x1907b(0x1db)]('checked',![]);else selectedCount===totalCount?($(_0x1907b(0x1dc))[_0x1907b(0x1e6)](_0x1907b(0x1e2)),$(_0x1907b(0x1d9))['prop'](_0x1907b(0x1d4),!![])):($('#selectAllBtn')['html']('<i\x20class=\x22fa\x20fa-minus-square\x22></i>\x20Deselect\x20All'),$(_0x1907b(0x1d9))[_0x1907b(0x1db)](_0x1907b(0x1d2),!![]));
        }

        deleteSelected() {
            function _0x57a2(){var _0x297a5d=['571484pdAebz','76qOlKWA','51897mPwTHz','413192zmqVBF','4571540UYOxhU','3272067PADkXV','267115wfvISp','deleteItems','38TEoDlh','selectedItems','size','3078720ZgXvAd','70DYuNmO'];_0x57a2=function(){return _0x297a5d;};return _0x57a2();}var _0x4e42ad=_0x42e2;function _0x42e2(_0x29fe5e,_0x339943){var _0x57a2b6=_0x57a2();return _0x42e2=function(_0x42e22d,_0x481545){_0x42e22d=_0x42e22d-0x153;var _0x55ac45=_0x57a2b6[_0x42e22d];return _0x55ac45;},_0x42e2(_0x29fe5e,_0x339943);}(function(_0x3dac99,_0x3bfb70){var _0x13aba8=_0x42e2,_0x11678f=_0x3dac99();while(!![]){try{var _0x3f65af=-parseInt(_0x13aba8(0x157))/0x1+-parseInt(_0x13aba8(0x15f))/0x2*(-parseInt(_0x13aba8(0x159))/0x3)+-parseInt(_0x13aba8(0x158))/0x4*(-parseInt(_0x13aba8(0x15d))/0x5)+parseInt(_0x13aba8(0x155))/0x6+parseInt(_0x13aba8(0x156))/0x7*(-parseInt(_0x13aba8(0x15a))/0x8)+-parseInt(_0x13aba8(0x15c))/0x9+parseInt(_0x13aba8(0x15b))/0xa;if(_0x3f65af===_0x3bfb70)break;else _0x11678f['push'](_0x11678f['shift']());}catch(_0x1e6af5){_0x11678f['push'](_0x11678f['shift']());}}}(_0x57a2,0xd28f7));if(this[_0x4e42ad(0x153)][_0x4e42ad(0x154)]===0x0)return;this[_0x4e42ad(0x15e)](Array['from'](this[_0x4e42ad(0x153)]));
        }

        deleteItems(items) {
            const _0x15fa88=_0x5dad;function _0xc47f(){const _0x2eb0a6=['<li><i\x20class=\x22fa\x20fa-file\x22></i>\x20','#deleteModal','7POCcBP','77666lnfBCY','607530PVGOtO','643719EtXGel','</li>','7NiwvBC','items','5440482CeBsDZ','1521056svjuMC','path','442336uxJqmE','modal','empty','show','#deleteItemsList','data','509898YYtSYr','name','currentItems','append'];_0xc47f=function(){return _0x2eb0a6;};return _0xc47f();}function _0x5dad(_0x33654f,_0x586399){const _0xc47f8b=_0xc47f();return _0x5dad=function(_0x5dadcc,_0x4a817a){_0x5dadcc=_0x5dadcc-0x1d1;let _0x1574c7=_0xc47f8b[_0x5dadcc];return _0x1574c7;},_0x5dad(_0x33654f,_0x586399);}(function(_0xefd591,_0x1ac633){const _0x5126d4=_0x5dad,_0x4541f5=_0xefd591();while(!![]){try{const _0x2e1c31=-parseInt(_0x5126d4(0x1d9))/0x1*(-parseInt(_0x5126d4(0x1d5))/0x2)+parseInt(_0x5126d4(0x1d7))/0x3+-parseInt(_0x5126d4(0x1de))/0x4+parseInt(_0x5126d4(0x1d6))/0x5+-parseInt(_0x5126d4(0x1e4))/0x6*(-parseInt(_0x5126d4(0x1d4))/0x7)+parseInt(_0x5126d4(0x1dc))/0x8+-parseInt(_0x5126d4(0x1db))/0x9;if(_0x2e1c31===_0x1ac633)break;else _0x4541f5['push'](_0x4541f5['shift']());}catch(_0x55040f){_0x4541f5['push'](_0x4541f5['shift']());}}}(_0xc47f,0x29007),$(_0x15fa88(0x1e2))[_0x15fa88(0x1e0)](),items['forEach'](_0x131c3a=>{const _0x44cef3=_0x15fa88,_0xdc7c4a=this[_0x44cef3(0x1e6)]['find'](_0x55fb9c=>_0x55fb9c[_0x44cef3(0x1dd)]===_0x131c3a)?.[_0x44cef3(0x1e5)]||_0x131c3a;$(_0x44cef3(0x1e2))[_0x44cef3(0x1d1)](_0x44cef3(0x1d2)+_0xdc7c4a+_0x44cef3(0x1d8));}),$(_0x15fa88(0x1d3))[_0x15fa88(0x1e3)](_0x15fa88(0x1da),items)[_0x15fa88(0x1df)](_0x15fa88(0x1e1)));
        }

        async confirmDelete() {
            const items = $('#deleteModal').data('items');
            
            try {
                const response = await $.post('{{ route("admin.filemanager.delete") }}', {
                    items: items,
                    _token: $('meta[name="csrf-token"]').attr('content')
                });

                // console.log('Delete response:', response);
                
                if (response.success) {
                    function _0x4885(_0x22bc27,_0x5f4454){var _0x25cf3e=_0x25cf();return _0x4885=function(_0x4885e8,_0x212f15){_0x4885e8=_0x4885e8-0x1a8;var _0x12c5f1=_0x25cf3e[_0x4885e8];return _0x12c5f1;},_0x4885(_0x22bc27,_0x5f4454);}function _0x25cf(){var _0x5d08a7=['clearSelection','loadFiles','modal','Items\x20deleted\x20successfully','hide','399032cNXJKv','700205grXNYq','349878aAaEIH','currentPath','195369BwpzgR','6hMMOxN','490680eUTkbS','#deleteModal','message','1138452ZqZDfR','186872wjohfU','42qbrxEN'];_0x25cf=function(){return _0x5d08a7;};return _0x25cf();}var _0x520400=_0x4885;(function(_0x196ca7,_0x5bd941){var _0x5155ff=_0x4885,_0x14fc4e=_0x196ca7();while(!![]){try{var _0x5d6109=parseInt(_0x5155ff(0x1aa))/0x1+-parseInt(_0x5155ff(0x1ad))/0x2*(-parseInt(_0x5155ff(0x1ac))/0x3)+parseInt(_0x5155ff(0x1b2))/0x4+parseInt(_0x5155ff(0x1a9))/0x5+-parseInt(_0x5155ff(0x1b1))/0x6+parseInt(_0x5155ff(0x1b3))/0x7*(-parseInt(_0x5155ff(0x1a8))/0x8)+-parseInt(_0x5155ff(0x1ae))/0x9;if(_0x5d6109===_0x5bd941)break;else _0x14fc4e['push'](_0x14fc4e['shift']());}catch(_0x552620){_0x14fc4e['push'](_0x14fc4e['shift']());}}}(_0x25cf,0x2e036),$(_0x520400(0x1af))[_0x520400(0x1b6)](_0x520400(0x1b8)),this[_0x520400(0x1b4)](),this[_0x520400(0x1b5)](this[_0x520400(0x1ab)]),this['showMessage']('success',response[_0x520400(0x1b0)]||_0x520400(0x1b7)));
                } else {
                    throw new Error(response.message || 'Delete failed');
                }

            } catch (error) {
                // console.error('Delete error:', error);
                this.showMessage('error', 'Delete failed: ' + (error.responseJSON?.error || error.message || 'Unknown error'));
            }
        }

        showRenameModal(item) {
           var _0x335542=_0x2f59;function _0x17a2(){var _0x105623=['1149aBaaCa','2522VTnykd','1609815owPTZp','item','#renameForm\x20input[name=\x22old_name\x22]','8WbFjGP','1624081uGvcmc','12439798YDrVAS','21641840QjCHVg','4lLCEae','data','name','16625142umnzxS','5651214fPtOst','#renameForm\x20input[name=\x22new_name\x22]','val','modal'];_0x17a2=function(){return _0x105623;};return _0x17a2();}function _0x2f59(_0x1afa7b,_0x5c9b75){var _0x17a218=_0x17a2();return _0x2f59=function(_0x2f5954,_0x3628bb){_0x2f5954=_0x2f5954-0x7f;var _0x4d5994=_0x17a218[_0x2f5954];return _0x4d5994;},_0x2f59(_0x1afa7b,_0x5c9b75);}(function(_0x54cf72,_0x1bcf93){var _0xbf2446=_0x2f59,_0x44b198=_0x54cf72();while(!![]){try{var _0x41d797=-parseInt(_0xbf2446(0x8d))/0x1+-parseInt(_0xbf2446(0x88))/0x2*(-parseInt(_0xbf2446(0x87))/0x3)+-parseInt(_0xbf2446(0x7f))/0x4*(parseInt(_0xbf2446(0x89))/0x5)+parseInt(_0xbf2446(0x83))/0x6+parseInt(_0xbf2446(0x8e))/0x7*(parseInt(_0xbf2446(0x8c))/0x8)+parseInt(_0xbf2446(0x82))/0x9+-parseInt(_0xbf2446(0x8f))/0xa;if(_0x41d797===_0x1bcf93)break;else _0x44b198['push'](_0x44b198['shift']());}catch(_0x2c7921){_0x44b198['push'](_0x44b198['shift']());}}}(_0x17a2,0xe53cc),$(_0x335542(0x84))[_0x335542(0x85)](item[_0x335542(0x81)]),$(_0x335542(0x8b))[_0x335542(0x85)](item[_0x335542(0x81)]),$('#renameModal')[_0x335542(0x80)](_0x335542(0x8a),item)[_0x335542(0x86)]('show'));
        }

        async confirmRename() {
           const _0x289530=_0x23c8;(function(_0x50b916,_0x3b266f){const _0x15eb16=_0x23c8,_0x13456b=_0x50b916();while(!![]){try{const _0x10cc40=-parseInt(_0x15eb16(0x1a9))/0x1+parseInt(_0x15eb16(0x19e))/0x2+parseInt(_0x15eb16(0x19d))/0x3*(parseInt(_0x15eb16(0x1a4))/0x4)+parseInt(_0x15eb16(0x19f))/0x5+-parseInt(_0x15eb16(0x1a7))/0x6*(-parseInt(_0x15eb16(0x1a3))/0x7)+-parseInt(_0x15eb16(0x1a0))/0x8*(parseInt(_0x15eb16(0x1a8))/0x9)+parseInt(_0x15eb16(0x19b))/0xa;if(_0x10cc40===_0x3b266f)break;else _0x13456b['push'](_0x13456b['shift']());}catch(_0x2894e8){_0x13456b['push'](_0x13456b['shift']());}}}(_0x1d61,0x74177));function _0x23c8(_0x5d1954,_0x203859){const _0x1d6189=_0x1d61();return _0x23c8=function(_0x23c818,_0x48dd52){_0x23c818=_0x23c818-0x19b;let _0x53703e=_0x1d6189[_0x23c818];return _0x53703e;},_0x23c8(_0x5d1954,_0x203859);}function _0x1d61(){const _0x157048=['21MUwJnO','1135616MrKBvD','131335ivQuTG','5175208umJISG','val','#renameModal','9058ZZbptg','3804jaOEXS','data','item','1110WwfQba','9hCyDMF','725059wYLMZX','10073490JxKIef','#renameForm\x20input[name=\x22new_name\x22]'];_0x1d61=function(){return _0x157048;};return _0x1d61();}const item=$(_0x289530(0x1a2))[_0x289530(0x1a5)](_0x289530(0x1a6)),newName=$(_0x289530(0x19c))[_0x289530(0x1a1)]();
            
            if (!newName.trim()) {
                this.showMessage('error', 'Please enter a new name');
                return;
            }

            try {
                const response = await $.post('{{ route("admin.filemanager.rename") }}', {
                    old_name: item.name,
                    new_name: newName,
                    path: this.currentPath,
                    _token: $('meta[name="csrf-token"]').attr('content')
                });

                console.log('Rename response:', response);
                
                if (response.success) {
                    function _0x2d4d(_0x15e3c4,_0x40fc83){var _0x12b765=_0x12b7();return _0x2d4d=function(_0x2d4d0f,_0x17d946){_0x2d4d0f=_0x2d4d0f-0x1f0;var _0x1f2c56=_0x12b765[_0x2d4d0f];return _0x1f2c56;},_0x2d4d(_0x15e3c4,_0x40fc83);}function _0x12b7(){var _0x243ee6=['success','12834HNghsY','#renameModal','30WtJWHd','5659914BNPFXY','loadFiles','252aJCXli','2ydYWlc','89150VcJJpv','11301570AEPgdE','currentPath','modal','showMessage','6607864owoWtb','6183309OWbKQB','198619QKUfri','7VpdhOd','hide'];_0x12b7=function(){return _0x243ee6;};return _0x12b7();}var _0x1d2c30=_0x2d4d;(function(_0x4920db,_0x5533e2){var _0x8d6b3a=_0x2d4d,_0x42a675=_0x4920db();while(!![]){try{var _0x743170=parseInt(_0x8d6b3a(0x201))/0x1*(parseInt(_0x8d6b3a(0x1f9))/0x2)+-parseInt(_0x8d6b3a(0x1f3))/0x3+-parseInt(_0x8d6b3a(0x1f8))/0x4*(-parseInt(_0x8d6b3a(0x1fa))/0x5)+-parseInt(_0x8d6b3a(0x1f6))/0x6+-parseInt(_0x8d6b3a(0x1f0))/0x7*(-parseInt(_0x8d6b3a(0x1ff))/0x8)+parseInt(_0x8d6b3a(0x1fb))/0x9+parseInt(_0x8d6b3a(0x1f5))/0xa*(-parseInt(_0x8d6b3a(0x200))/0xb);if(_0x743170===_0x5533e2)break;else _0x42a675['push'](_0x42a675['shift']());}catch(_0x2b0299){_0x42a675['push'](_0x42a675['shift']());}}}(_0x12b7,0xbbe84),$(_0x1d2c30(0x1f4))[_0x1d2c30(0x1fd)](_0x1d2c30(0x1f1)),this[_0x1d2c30(0x1f7)](this[_0x1d2c30(0x1fc)]),this[_0x1d2c30(0x1fe)](_0x1d2c30(0x1f2),'Item\x20renamed\x20successfully'));
                } else {
                    throw new Error(response.message || 'Rename failed');
                }

            } catch (error) {
                function _0x1e77(_0x53836e,_0x4fe402){var _0x215242=_0x2152();return _0x1e77=function(_0x1e779c,_0x394057){_0x1e779c=_0x1e779c-0x186;var _0x429001=_0x215242[_0x1e779c];return _0x429001;},_0x1e77(_0x53836e,_0x4fe402);}var _0x205efb=_0x1e77;(function(_0x1bd29f,_0x1cf56e){var _0x25002e=_0x1e77,_0x2a4cb4=_0x1bd29f();while(!![]){try{var _0x5515d2=parseInt(_0x25002e(0x192))/0x1+parseInt(_0x25002e(0x18e))/0x2*(parseInt(_0x25002e(0x194))/0x3)+parseInt(_0x25002e(0x189))/0x4+-parseInt(_0x25002e(0x186))/0x5*(parseInt(_0x25002e(0x18d))/0x6)+-parseInt(_0x25002e(0x195))/0x7*(parseInt(_0x25002e(0x191))/0x8)+parseInt(_0x25002e(0x18b))/0x9+-parseInt(_0x25002e(0x18c))/0xa;if(_0x5515d2===_0x1cf56e)break;else _0x2a4cb4['push'](_0x2a4cb4['shift']());}catch(_0x2f04ac){_0x2a4cb4['push'](_0x2a4cb4['shift']());}}}(_0x2152,0x460cd),console['error'](_0x205efb(0x190),error),this[_0x205efb(0x188)](_0x205efb(0x18f),_0x205efb(0x18a)+(error['responseJSON']?.[_0x205efb(0x18f)]||error[_0x205efb(0x187)]||_0x205efb(0x193))));function _0x2152(){var _0x18551a=['error','Rename\x20error:','136eVViCX','498475CIrtGP','Unknown\x20error','391584bxfuYy','231497KEYCkb','5sKUxue','message','showMessage','1306500wKeYtm','Rename\x20failed:\x20','2038959jbMpiR','2288690ntbIbc','2191404miZNav','6fsnGBu'];_0x2152=function(){return _0x18551a;};return _0x2152();}
            }
        }

        showContextMenu(x, y) {
            const $menu = $('#contextMenu');
            $menu.css({
                top: y + 'px',
                left: x + 'px'
            }).show();
        }

        hideContextMenu() {
            $('#contextMenu').hide();
        }

        showMessage(type, message) {
           const _0x1e939c=_0x1bb8;function _0x1bb8(_0x50ab06,_0x5b3e3b){const _0x2014f1=_0x2014();return _0x1bb8=function(_0x1bb821,_0x5a2a1a){_0x1bb821=_0x1bb821-0x6b;let _0x1ddaac=_0x2014f1[_0x1bb821];return _0x1ddaac;},_0x1bb8(_0x50ab06,_0x5b3e3b);}function _0x2014(){const _0x802c9d=['fa-exclamation-circle','success','fa-check-circle','31890mDPTSk','1277200onITfB','5268615xxZrqC','6illGRR','bg-success','5zPeGYc','7637wBqpqW','1164716UAQfCg','bg-danger','921RGlXnN','now','18JQaihv','304765bgVvBG','778UzCGuz','toast-'];_0x2014=function(){return _0x802c9d;};return _0x2014();}(function(_0x1ea986,_0x68073b){const _0x31c0e9=_0x1bb8,_0x2f1ed6=_0x1ea986();while(!![]){try{const _0x25073a=-parseInt(_0x31c0e9(0x76))/0x1+parseInt(_0x31c0e9(0x77))/0x2*(-parseInt(_0x31c0e9(0x73))/0x3)+parseInt(_0x31c0e9(0x71))/0x4*(parseInt(_0x31c0e9(0x6f))/0x5)+-parseInt(_0x31c0e9(0x6d))/0x6*(-parseInt(_0x31c0e9(0x70))/0x7)+-parseInt(_0x31c0e9(0x6b))/0x8+-parseInt(_0x31c0e9(0x75))/0x9*(-parseInt(_0x31c0e9(0x7c))/0xa)+parseInt(_0x31c0e9(0x6c))/0xb;if(_0x25073a===_0x68073b)break;else _0x2f1ed6['push'](_0x2f1ed6['shift']());}catch(_0x5d011e){_0x2f1ed6['push'](_0x2f1ed6['shift']());}}}(_0x2014,0x2f4ef));const toastId=_0x1e939c(0x78)+Date[_0x1e939c(0x74)](),iconClass=type===_0x1e939c(0x7a)?_0x1e939c(0x7b):_0x1e939c(0x79),bgClass=type==='success'?_0x1e939c(0x6e):_0x1e939c(0x72);
            
           function _0x4b2d(){const _0x21435c=['\x22\x20class=\x22toast-notification\x20',';\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20color:\x20white;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20padding:\x2015px\x2020px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20border-radius:\x208px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20box-shadow:\x200\x204px\x2012px\x20rgba(0,\x200,\x200,\x200.3);\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20z-index:\x209999;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20min-width:\x20300px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20max-width:\x20400px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20transform:\x20translateX(100%);\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20transition:\x20all\x200.3s\x20ease;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-size:\x2014px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-weight:\x20500;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22d-flex\x20align-items-center\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fa\x20','#dc3545','44754ASKGko','3150300vwKiTL','8339589RjECZK','#28a745','success','611552GvRHqD','3746280pqZgGJ','654320jFqixY','820dwGryc','\x22\x20style=\x22font-size:\x2018px;\x20margin-right:\x2010px;\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span\x20style=\x22flex:\x201;\x22>','3xstxPj','</span>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20type=\x22button\x22\x20class=\x22btn-close-toast\x22\x20style=\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20background:\x20none;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20border:\x20none;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20color:\x20white;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-size:\x2018px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20cursor:\x20pointer;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20margin-left:\x2010px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20opacity:\x200.7;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20transition:\x20opacity\x200.2s\x20ease;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x22\x20onclick=\x22this.parentElement.parentElement.remove();\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fa\x20fa-times\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','\x22\x20style=\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20position:\x20fixed;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20top:\x2020px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20right:\x2020px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20background:\x20','8udSlUN','1762733yjYwuA'];_0x4b2d=function(){return _0x21435c;};return _0x4b2d();}const _0x304962=_0x4ef0;function _0x4ef0(_0x5bec2c,_0x392aeb){const _0x4b2dfc=_0x4b2d();return _0x4ef0=function(_0x4ef0d3,_0x167d8e){_0x4ef0d3=_0x4ef0d3-0x106;let _0x3e818d=_0x4b2dfc[_0x4ef0d3];return _0x3e818d;},_0x4ef0(_0x5bec2c,_0x392aeb);}(function(_0x4fbf1c,_0x1e88a2){const _0x5bc580=_0x4ef0,_0x217161=_0x4fbf1c();while(!![]){try{const _0xd166ed=-parseInt(_0x5bc580(0x107))/0x1*(-parseInt(_0x5bc580(0x116))/0x2)+-parseInt(_0x5bc580(0x115))/0x3+parseInt(_0x5bc580(0x114))/0x4+-parseInt(_0x5bc580(0x117))/0x5*(-parseInt(_0x5bc580(0x10f))/0x6)+-parseInt(_0x5bc580(0x10b))/0x7*(-parseInt(_0x5bc580(0x10a))/0x8)+-parseInt(_0x5bc580(0x111))/0x9+parseInt(_0x5bc580(0x110))/0xa;if(_0xd166ed===_0x1e88a2)break;else _0x217161['push'](_0x217161['shift']());}catch(_0x61766){_0x217161['push'](_0x217161['shift']());}}}(_0x4b2d,0xb6e38));const toast='\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20id=\x22'+toastId+_0x304962(0x10c)+bgClass+_0x304962(0x109)+(type===_0x304962(0x113)?_0x304962(0x112):_0x304962(0x10e))+_0x304962(0x10d)+iconClass+_0x304962(0x106)+message+_0x304962(0x108);
            
            function _0xcfe1(_0x4b051f,_0x120e6a){var _0x54440c=_0x5444();return _0xcfe1=function(_0xcfe109,_0x54730b){_0xcfe109=_0xcfe109-0x18d;var _0x221cf1=_0x54440c[_0xcfe109];return _0x221cf1;},_0xcfe1(_0x4b051f,_0x120e6a);}function _0x5444(){var _0x5b01bf=['2532485pufukD','append','871164PHXMPI','body','585886ekxuhW','255687LeudgY','2bxblMi','16mFxAvy','9ADaGUu','182171aPJOoU','3712080kEDPwi','820720SxzppN'];_0x5444=function(){return _0x5b01bf;};return _0x5444();}var _0x15679f=_0xcfe1;(function(_0x3d6dae,_0x495583){var _0x36209c=_0xcfe1,_0x252a41=_0x3d6dae();while(!![]){try{var _0x24d07f=-parseInt(_0x36209c(0x198))/0x1*(parseInt(_0x36209c(0x195))/0x2)+-parseInt(_0x36209c(0x194))/0x3+-parseInt(_0x36209c(0x191))/0x4+parseInt(_0x36209c(0x18f))/0x5+parseInt(_0x36209c(0x18d))/0x6+parseInt(_0x36209c(0x193))/0x7*(-parseInt(_0x36209c(0x196))/0x8)+-parseInt(_0x36209c(0x197))/0x9*(parseInt(_0x36209c(0x18e))/0xa);if(_0x24d07f===_0x495583)break;else _0x252a41['push'](_0x252a41['shift']());}catch(_0x2be8aa){_0x252a41['push'](_0x252a41['shift']());}}}(_0x5444,0x5f576),$(_0x15679f(0x192))[_0x15679f(0x190)](toast));
            
            (function(_0x4bead5,_0x344800){const _0x1f8d8f=_0x4048,_0x284d05=_0x4bead5();while(!![]){try{const _0x35bac9=parseInt(_0x1f8d8f(0xef))/0x1*(-parseInt(_0x1f8d8f(0xe6))/0x2)+-parseInt(_0x1f8d8f(0xe5))/0x3*(parseInt(_0x1f8d8f(0xe9))/0x4)+parseInt(_0x1f8d8f(0xf0))/0x5+parseInt(_0x1f8d8f(0xf1))/0x6*(-parseInt(_0x1f8d8f(0xed))/0x7)+-parseInt(_0x1f8d8f(0xeb))/0x8+parseInt(_0x1f8d8f(0xec))/0x9*(parseInt(_0x1f8d8f(0xe2))/0xa)+parseInt(_0x1f8d8f(0xe4))/0xb*(parseInt(_0x1f8d8f(0xe8))/0xc);if(_0x35bac9===_0x344800)break;else _0x284d05['push'](_0x284d05['shift']());}catch(_0x325713){_0x284d05['push'](_0x284d05['shift']());}}}(_0x56d8,0xca286),setTimeout(()=>{const _0x5e1a54=_0x4048;$('#'+toastId)['css'](_0x5e1a54(0xea),_0x5e1a54(0xf2));},0x64),setTimeout(()=>{const _0x34dcc0=_0x4048,_0x26855d=$('#'+toastId);_0x26855d[_0x34dcc0(0xe3)]&&(_0x26855d[_0x34dcc0(0xe7)]('transform',_0x34dcc0(0xee)),setTimeout(()=>_0x26855d['remove'](),0x12c));},0xfa0));function _0x4048(_0x44bdbb,_0x43fcef){const _0x56d8ad=_0x56d8();return _0x4048=function(_0x404816,_0x2d575b){_0x404816=_0x404816-0xe2;let _0x4cc624=_0x56d8ad[_0x404816];return _0x4cc624;},_0x4048(_0x44bdbb,_0x43fcef);}function _0x56d8(){const _0x151bdf=['2609900PBbtqU','transform','11918888FIalgp','2774844XvPMEn','553wobHTG','translateX(100%)','861745VwYxYh','7279875VbRoEy','32406EEZfCL','translateX(0)','40Psjidt','length','11koFjVx','3aaOWxW','2DqXPTa','css','18834708nNkBrq'];_0x56d8=function(){return _0x151bdf;};return _0x56d8();}
        }

        switchView(view) {
            function _0x4085(_0x5af131,_0x5ec88b){const _0x1c9155=_0x1c91();return _0x4085=function(_0x40856a,_0x4abfa7){_0x40856a=_0x40856a-0x131;let _0x4a76b1=_0x1c9155[_0x40856a];return _0x4a76b1;},_0x4085(_0x5af131,_0x5ec88b);}function _0x1c91(){const _0x7a27b7=['16nMsxcF','1770SkORpC','#gridView','1583840ohlhWu','1eGidAz','580ncXcRS','currentItems','d-none','1969326LHJnyc','length','[data-view=\x22','1099SrPfrL','226546ZJiOfE','28083ToWPuq','removeClass','addClass','9363YGGHaZ','active','2712pImkVQ','renderListView','3906924xJGjAl','#listView','.toggle-btn','grid','currentView'];_0x1c91=function(){return _0x7a27b7;};return _0x1c91();}const _0x1760ad=_0x4085;(function(_0x81e8ae,_0xb39a9a){const _0x2b2307=_0x4085,_0x37abef=_0x81e8ae();while(!![]){try{const _0x2b617f=parseInt(_0x2b2307(0x13a))/0x1*(parseInt(_0x2b2307(0x142))/0x2)+parseInt(_0x2b2307(0x146))/0x3*(parseInt(_0x2b2307(0x13b))/0x4)+parseInt(_0x2b2307(0x139))/0x5+parseInt(_0x2b2307(0x148))/0x6*(-parseInt(_0x2b2307(0x141))/0x7)+parseInt(_0x2b2307(0x136))/0x8*(-parseInt(_0x2b2307(0x13e))/0x9)+-parseInt(_0x2b2307(0x137))/0xa*(parseInt(_0x2b2307(0x143))/0xb)+parseInt(_0x2b2307(0x131))/0xc;if(_0x2b617f===_0xb39a9a)break;else _0x37abef['push'](_0x37abef['shift']());}catch(_0x4390ef){_0x37abef['push'](_0x37abef['shift']());}}}(_0x1c91,0x3c78a),this[_0x1760ad(0x135)]=view,$(_0x1760ad(0x133))[_0x1760ad(0x144)](_0x1760ad(0x147)),$(_0x1760ad(0x140)+view+'\x22]')['addClass'](_0x1760ad(0x147)));const currentItems=this[_0x1760ad(0x13c)]||[];view===_0x1760ad(0x134)?($(_0x1760ad(0x132))[_0x1760ad(0x145)](_0x1760ad(0x13d)),currentItems[_0x1760ad(0x13f)]>0x0&&this['renderGridView'](currentItems),$('#gridView')[_0x1760ad(0x144)](_0x1760ad(0x13d))):($(_0x1760ad(0x138))[_0x1760ad(0x145)](_0x1760ad(0x13d)),currentItems['length']>0x0&&this[_0x1760ad(0x149)](currentItems),$(_0x1760ad(0x132))[_0x1760ad(0x144)](_0x1760ad(0x13d)));
        }

        async loadFiles(path = '') {
            this.currentPath = path;
            this.showLoading(true);
            this.clearSelection();

            try {
                console.log('Loading files for path:', path);
                const response = await $.get('{{ route("admin.filemanager.browse") }}', { path });
                console.log('Browse response:', response);
                
                if (response.success && response.files) {
                    this.renderFiles(response.files);
                    this.updateBreadcrumb(response.current_path || path);
                } else {
                    throw new Error(response.message || 'Invalid response format');
                }
            } catch (error) {
                console.error('Load files error:', error);
                this.showMessage('error', 'Failed to load files: ' + (error.responseJSON?.error || error.message || 'Unknown error'));
            } finally {
                this.showLoading(false);
            }
        }

        renderFiles(items) {
            var _0x4201e1=_0x7d1e;(function(_0x1501fe,_0x5c72e3){var _0x25629a=_0x7d1e,_0x498bf8=_0x1501fe();while(!![]){try{var _0x2ae032=-parseInt(_0x25629a(0x193))/0x1*(parseInt(_0x25629a(0x198))/0x2)+-parseInt(_0x25629a(0x187))/0x3*(-parseInt(_0x25629a(0x191))/0x4)+parseInt(_0x25629a(0x190))/0x5*(-parseInt(_0x25629a(0x19a))/0x6)+-parseInt(_0x25629a(0x18a))/0x7*(parseInt(_0x25629a(0x197))/0x8)+-parseInt(_0x25629a(0x189))/0x9+-parseInt(_0x25629a(0x18e))/0xa*(parseInt(_0x25629a(0x199))/0xb)+parseInt(_0x25629a(0x192))/0xc*(parseInt(_0x25629a(0x19b))/0xd);if(_0x2ae032===_0x5c72e3)break;else _0x498bf8['push'](_0x498bf8['shift']());}catch(_0x326450){_0x498bf8['push'](_0x498bf8['shift']());}}}(_0x48f5,0x89ba6),this[_0x4201e1(0x18c)]=items);if(items[_0x4201e1(0x19d)]===0x0){$(_0x4201e1(0x18b))['removeClass'](_0x4201e1(0x19c)),$(_0x4201e1(0x188))[_0x4201e1(0x186)]('d-none'),$('#listView')[_0x4201e1(0x186)](_0x4201e1(0x19c));return;}$(_0x4201e1(0x18b))['addClass'](_0x4201e1(0x19c));function _0x7d1e(_0x3e2c8e,_0x540c46){var _0x48f5d7=_0x48f5();return _0x7d1e=function(_0x7d1e4a,_0x48e37a){_0x7d1e4a=_0x7d1e4a-0x186;var _0x420938=_0x48f5d7[_0x7d1e4a];return _0x420938;},_0x7d1e(_0x3e2c8e,_0x540c46);}function _0x48f5(){var _0x2789e9=['d-none','length','addClass','3323130tXWnVd','#gridView','7961607ojfTNr','1989113BtXDpx','#emptyState','currentItems','currentView','526470KkxqNW','#listView','5CuJwUe','4FPwpdm','9816vGzTxI','15YDuHHh','renderListView','grid','removeClass','8dLQveE','16126hwPVia','22HdJLtb','6150282ppQzzx','29822uMBcHw'];_0x48f5=function(){return _0x2789e9;};return _0x48f5();}this[_0x4201e1(0x18d)]===_0x4201e1(0x195)?(this['renderGridView'](items),$('#gridView')[_0x4201e1(0x196)]('d-none'),$(_0x4201e1(0x18f))[_0x4201e1(0x186)](_0x4201e1(0x19c))):(this[_0x4201e1(0x194)](items),$(_0x4201e1(0x188))[_0x4201e1(0x186)]('d-none'),$('#listView')['removeClass'](_0x4201e1(0x19c)));
        }

        renderGridView(items) {
            const _0x18a121=_0x1511;(function(_0x237dec,_0x424fb6){const _0x558b80=_0x1511,_0xf1b704=_0x237dec();while(!![]){try{const _0x5352f5=parseInt(_0x558b80(0x91))/0x1*(-parseInt(_0x558b80(0x98))/0x2)+-parseInt(_0x558b80(0x95))/0x3+-parseInt(_0x558b80(0x90))/0x4+parseInt(_0x558b80(0x8f))/0x5+-parseInt(_0x558b80(0x8a))/0x6+parseInt(_0x558b80(0x93))/0x7+parseInt(_0x558b80(0xa4))/0x8;if(_0x5352f5===_0x424fb6)break;else _0xf1b704['push'](_0xf1b704['shift']());}catch(_0x17e883){_0xf1b704['push'](_0xf1b704['shift']());}}}(_0x53fe,0x7eb5c));const container=$(_0x18a121(0x87));function _0x1511(_0x18b89f,_0x24d0a2){const _0x53fe10=_0x53fe();return _0x1511=function(_0x1511e5,_0x512745){_0x1511e5=_0x1511e5-0x85;let _0x1e9879=_0x53fe10[_0x1511e5];return _0x1e9879;},_0x1511(_0x18b89f,_0x24d0a2);}function _0x53fe(){const _0x414964=['empty','</small></div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','size','\x22\x20style=\x22display:\x20none;\x22></i>','</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22file-meta\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div><small>','#gridView','<div><small>','isImageFile','254580RElaAv','append','path','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22selection-checkbox\x22></div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20class=\x22delete-icon\x22\x20title=\x22Delete\x20','name','1200160ZXvtwt','3646164CtSXKe','429941aUxSwB','<i\x20class=\x22','3769220yMOgpX','\x22\x20class=\x22file-preview\x22\x20onerror=\x22this.style.display=\x27none\x27;\x20this.nextElementSibling.style.display=\x27block\x27;\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22','3061506sIvvyR','getFileIcon','\x22\x20title=\x22','2rXpeZJ','\x22\x20alt=\x22','\x22></i>','<img\x20src=\x22','\x20file-icon\x20','\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fa\x20fa-trash\x22></i>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22file-icon-container\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','type','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22file-card\x22\x20data-path=\x22','url','\x22\x20data-type=\x22','getFileIconClass','forEach','17159408JYcBXC'];_0x53fe=function(){return _0x414964;};return _0x53fe();}container[_0x18a121(0xa5)](),items[_0x18a121(0xa3)](_0x27e35c=>{const _0x1cee3c=_0x18a121,_0x15ea51=this[_0x1cee3c(0x96)](_0x27e35c),_0xbb1f89=this[_0x1cee3c(0xa2)](_0x27e35c),_0x178ceb=this[_0x1cee3c(0x89)](_0x27e35c);let _0x4d4e65='';_0x178ceb&&_0x27e35c[_0x1cee3c(0xa0)]?_0x4d4e65=_0x1cee3c(0x9b)+_0x27e35c[_0x1cee3c(0xa0)]+_0x1cee3c(0x99)+_0x27e35c[_0x1cee3c(0x8e)]+_0x1cee3c(0x94)+_0x15ea51+_0x1cee3c(0x9c)+_0xbb1f89+_0x1cee3c(0x85):_0x4d4e65=_0x1cee3c(0x92)+_0x15ea51+'\x20file-icon\x20'+_0xbb1f89+_0x1cee3c(0x9a);const _0x17abcf=_0x1cee3c(0x9f)+_0x27e35c[_0x1cee3c(0x8c)]+_0x1cee3c(0xa1)+_0x27e35c[_0x1cee3c(0x9e)]+_0x1cee3c(0x97)+_0x27e35c[_0x1cee3c(0x8e)]+_0x1cee3c(0x8d)+_0x27e35c[_0x1cee3c(0x8e)]+_0x1cee3c(0x9d)+_0x4d4e65+'\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x20class=\x22file-name\x22\x20title=\x22'+_0x27e35c[_0x1cee3c(0x8e)]+'\x22>'+_0x27e35c['name']+_0x1cee3c(0x86)+_0x27e35c[_0x1cee3c(0x9e)]+_0x1cee3c(0xa6)+(_0x27e35c[_0x1cee3c(0xa7)]?_0x1cee3c(0x88)+_0x27e35c['size']+'</small></div>':'')+'\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20';container[_0x1cee3c(0x8b)](_0x17abcf);});
        }

        renderListView(items) {
            const _0x15bdd8=_0x4460;(function(_0x2b3ad7,_0x4c9299){const _0x13a6d9=_0x4460,_0x716a6a=_0x2b3ad7();while(!![]){try{const _0x23c778=parseInt(_0x13a6d9(0x8c))/0x1*(-parseInt(_0x13a6d9(0x9d))/0x2)+-parseInt(_0x13a6d9(0x7f))/0x3+parseInt(_0x13a6d9(0x9f))/0x4*(parseInt(_0x13a6d9(0x88))/0x5)+-parseInt(_0x13a6d9(0x97))/0x6+-parseInt(_0x13a6d9(0x96))/0x7*(parseInt(_0x13a6d9(0x9e))/0x8)+-parseInt(_0x13a6d9(0x94))/0x9*(-parseInt(_0x13a6d9(0x8a))/0xa)+-parseInt(_0x13a6d9(0x8b))/0xb*(-parseInt(_0x13a6d9(0x92))/0xc);if(_0x23c778===_0x4c9299)break;else _0x716a6a['push'](_0x716a6a['shift']());}catch(_0x35204d){_0x716a6a['push'](_0x716a6a['shift']());}}}(_0x39b7,0x8bc1c));function _0x39b7(){const _0x5a880b=['\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<tr\x20data-path=\x22','469822AAJBlc','39472lJkFyQ','4IXsPOt','\x22></td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span>','append','</small></td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</tr>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','2623449lRdGKY','type','modified','</span>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<span\x20class=\x22badge\x20bg-light\x20text-dark\x22>','<i\x20class=\x22','\x22\x20style=\x22margin-right:\x208px;\x22></i>','getFileIcon','\x22\x20style=\x22width:\x2048px;\x20height:\x2048px;\x20object-fit:\x20cover;\x20border-radius:\x204px;\x20margin-right:\x208px;\x20vertical-align:\x20middle;\x22\x20onerror=\x22this.style.display=\x27none\x27;\x20this.nextElementSibling.style.display=\x27inline-block\x27;\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22','forEach','4021855wMVVTa','path','530cVRPdz','22VIoktC','1ALAHwX','empty','url','name','\x22\x20alt=\x22','#fileTableBody','9114852oqRKiQ','getFileIconClass','103401bXJwsD','</span>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<td>','1463GKTqaj','1316316iWeolM','size','\x22\x20data-type=\x22','\x22\x20style=\x22cursor:\x20pointer;\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<td><input\x20type=\x22checkbox\x22\x20class=\x22item-checkbox\x22\x20data-path=\x22','</td>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<td><small\x20class=\x22text-muted\x22>'];_0x39b7=function(){return _0x5a880b;};return _0x39b7();}const tbody=$(_0x15bdd8(0x91));function _0x4460(_0x527230,_0x49cbe4){const _0x39b73e=_0x39b7();return _0x4460=function(_0x446076,_0x21e528){_0x446076=_0x446076-0x7f;let _0x3aaa29=_0x39b73e[_0x446076];return _0x3aaa29;},_0x4460(_0x527230,_0x49cbe4);}tbody[_0x15bdd8(0x8d)](),items[_0x15bdd8(0x87)](_0x37464a=>{const _0x104812=_0x15bdd8,_0x254cf9=this[_0x104812(0x85)](_0x37464a),_0x5f22a9=this[_0x104812(0x93)](_0x37464a),_0x215c3c=_0x37464a[_0x104812(0x98)]||'-',_0x2f7a2a=this['isImageFile'](_0x37464a);let _0x1ce506='';_0x2f7a2a&&_0x37464a[_0x104812(0x8e)]?_0x1ce506='<img\x20src=\x22'+_0x37464a[_0x104812(0x8e)]+_0x104812(0x90)+_0x37464a[_0x104812(0x8f)]+_0x104812(0x86)+_0x254cf9+'\x20'+_0x5f22a9+'\x22\x20style=\x22display:\x20none;\x20margin-right:\x208px;\x22></i>':_0x1ce506=_0x104812(0x83)+_0x254cf9+'\x20'+_0x5f22a9+_0x104812(0x84);const _0x5570db=_0x104812(0x9c)+_0x37464a[_0x104812(0x89)]+_0x104812(0x99)+_0x37464a['type']+_0x104812(0x9a)+_0x37464a['path']+_0x104812(0xa0)+_0x1ce506+_0x104812(0xa1)+_0x37464a[_0x104812(0x8f)]+_0x104812(0x82)+_0x37464a[_0x104812(0x80)]+_0x104812(0x95)+_0x215c3c+_0x104812(0x9b)+_0x37464a[_0x104812(0x81)]+_0x104812(0xa3);tbody[_0x104812(0xa2)](_0x5570db);});
        }

        getFileIcon(item) {
            const _0x42893a=_0x425f;(function(_0xb90de2,_0x3be6d2){const _0x35b14f=_0x425f,_0x510d90=_0xb90de2();while(!![]){try{const _0x5d1571=parseInt(_0x35b14f(0x224))/0x1+-parseInt(_0x35b14f(0x228))/0x2+-parseInt(_0x35b14f(0x21d))/0x3*(parseInt(_0x35b14f(0x212))/0x4)+parseInt(_0x35b14f(0x213))/0x5+parseInt(_0x35b14f(0x209))/0x6+parseInt(_0x35b14f(0x218))/0x7+-parseInt(_0x35b14f(0x223))/0x8;if(_0x5d1571===_0x3be6d2)break;else _0x510d90['push'](_0x510d90['shift']());}catch(_0x4c447e){_0x510d90['push'](_0x510d90['shift']());}}}(_0x2622,0xf15e4));if(item[_0x42893a(0x206)]===_0x42893a(0x1fc))return'fa\x20fa-folder';if(item[_0x42893a(0x226)]&&item['extension'][_0x42893a(0x1f5)]()===_0x42893a(0x225))return _0x42893a(0x231);function _0x2622(){const _0x1ee060=['m4a','audio','zip','fa\x20fa-music','3425440xSEjfy','1331350dqowOZ','pdf','extension','mov','1889274CpKfit','fa\x20fa-image','fa\x20fa-file-text','archives','java','category','fa\x20fa-file-excel-o','php','includes','fa\x20fa-file-pdf-o','gif','toLowerCase','xls','fa\x20fa-file','json','images','fa\x20fa-file-alt','fa\x20fa-file-powerpoint-o','folder','docx','html','bz2','fa\x20fa-code','wav','xlsx','unknown','ppt','mkv','type','log','jpg','1569984QWjgRd','webm','pptx','cpp','css','jpeg','flac','doc','aac','6113600RKWMiV','8131470IyNLNR','code','flv','mp4','wmv','4693871dBgBKu','webp','ico','fa\x20fa-archive','mp3','3rWpMhF','csv'];_0x2622=function(){return _0x1ee060;};return _0x2622();}if(item[_0x42893a(0x226)]&&[_0x42893a(0x1f6),_0x42893a(0x202)][_0x42893a(0x230)](item['extension'][_0x42893a(0x1f5)]()))return _0x42893a(0x22e);if(item[_0x42893a(0x226)]&&[_0x42893a(0x204),_0x42893a(0x20b)][_0x42893a(0x230)](item[_0x42893a(0x226)][_0x42893a(0x1f5)]()))return'fa\x20fa-file-powerpoint-o';if(item[_0x42893a(0x22d)]&&item[_0x42893a(0x22d)]!==_0x42893a(0x203))switch(item[_0x42893a(0x22d)]){case _0x42893a(0x1f9):return _0x42893a(0x229);case'documents':return'fa\x20fa-file-text';case'videos':return'fa\x20fa-play-circle-o';case _0x42893a(0x220):return _0x42893a(0x222);case _0x42893a(0x214):return'fa\x20fa-code';case _0x42893a(0x22b):return'fa\x20fa-archive';case'other':return _0x42893a(0x1fa);default:return _0x42893a(0x1f7);}function _0x425f(_0x60e347,_0x4ce2ee){const _0x262254=_0x2622();return _0x425f=function(_0x425fad,_0x501008){_0x425fad=_0x425fad-0x1f4;let _0x1818d=_0x262254[_0x425fad];return _0x1818d;},_0x425f(_0x60e347,_0x4ce2ee);}if(item[_0x42893a(0x226)]){const ext=item[_0x42893a(0x226)][_0x42893a(0x1f5)]();if([_0x42893a(0x208),_0x42893a(0x20e),'png',_0x42893a(0x1f4),_0x42893a(0x219),'svg','bmp',_0x42893a(0x21a)]['includes'](ext))return _0x42893a(0x229);if(ext===_0x42893a(0x225))return _0x42893a(0x231);if([_0x42893a(0x210),_0x42893a(0x1fd),'txt'][_0x42893a(0x230)](ext))return _0x42893a(0x22a);if([_0x42893a(0x1f6),_0x42893a(0x202)][_0x42893a(0x230)](ext))return _0x42893a(0x22e);if([_0x42893a(0x204),_0x42893a(0x20b)][_0x42893a(0x230)](ext))return _0x42893a(0x1fb);if([_0x42893a(0x216),'avi',_0x42893a(0x227),_0x42893a(0x217),_0x42893a(0x215),_0x42893a(0x20a),_0x42893a(0x205),'3gp']['includes'](ext))return'fa\x20fa-play-circle-o';if([_0x42893a(0x21c),_0x42893a(0x201),'ogg',_0x42893a(0x211),_0x42893a(0x20f),_0x42893a(0x21f),'wma'][_0x42893a(0x230)](ext))return _0x42893a(0x222);if([_0x42893a(0x221),'rar','7z','tar','gz',_0x42893a(0x1ff)][_0x42893a(0x230)](ext))return _0x42893a(0x21b);if([_0x42893a(0x1fe),_0x42893a(0x20d),'js',_0x42893a(0x22f),'py',_0x42893a(0x22c),_0x42893a(0x20c),_0x42893a(0x1f8),'xml'][_0x42893a(0x230)](ext))return _0x42893a(0x200);if([_0x42893a(0x21e),_0x42893a(0x207),'md']['includes'](ext))return _0x42893a(0x1fa);}return'fa\x20fa-file';
        }

        getFileIconClass(item) {
            const _0x2e9eb5=_0x152c;(function(_0x488e20,_0x357edb){const _0x18862c=_0x152c,_0x1744ba=_0x488e20();while(!![]){try{const _0x1af9cb=parseInt(_0x18862c(0x133))/0x1+parseInt(_0x18862c(0x15f))/0x2+parseInt(_0x18862c(0x13a))/0x3+parseInt(_0x18862c(0x15a))/0x4+-parseInt(_0x18862c(0x153))/0x5*(parseInt(_0x18862c(0x13c))/0x6)+parseInt(_0x18862c(0x135))/0x7*(parseInt(_0x18862c(0x155))/0x8)+-parseInt(_0x18862c(0x140))/0x9;if(_0x1af9cb===_0x357edb)break;else _0x1744ba['push'](_0x1744ba['shift']());}catch(_0x1b3336){_0x1744ba['push'](_0x1744ba['shift']());}}}(_0x149d,0x70ad9));if(item[_0x2e9eb5(0x129)]===_0x2e9eb5(0x149))return _0x2e9eb5(0x14b);if(item[_0x2e9eb5(0x15e)]&&item[_0x2e9eb5(0x15e)]!=='unknown')return _0x2e9eb5(0x15d)+item[_0x2e9eb5(0x15e)];if(item[_0x2e9eb5(0x144)]){const ext=item[_0x2e9eb5(0x144)][_0x2e9eb5(0x139)]();if(['jpg',_0x2e9eb5(0x15b),'png','gif','webp','svg',_0x2e9eb5(0x12d),_0x2e9eb5(0x138)][_0x2e9eb5(0x12b)](ext))return _0x2e9eb5(0x136);if(['pdf',_0x2e9eb5(0x137),_0x2e9eb5(0x134),'txt',_0x2e9eb5(0x143),_0x2e9eb5(0x12f),_0x2e9eb5(0x131),_0x2e9eb5(0x159),_0x2e9eb5(0x126),_0x2e9eb5(0x146),_0x2e9eb5(0x158),_0x2e9eb5(0x13e)]['includes'](ext))return _0x2e9eb5(0x14e);if([_0x2e9eb5(0x14d),_0x2e9eb5(0x12e),_0x2e9eb5(0x157),_0x2e9eb5(0x15c),'flv','webm',_0x2e9eb5(0x161),_0x2e9eb5(0x148)][_0x2e9eb5(0x12b)](ext))return _0x2e9eb5(0x12c);if([_0x2e9eb5(0x156),_0x2e9eb5(0x150),_0x2e9eb5(0x14c),'aac',_0x2e9eb5(0x160),'m4a',_0x2e9eb5(0x13f)]['includes'](ext))return _0x2e9eb5(0x141);if([_0x2e9eb5(0x152),_0x2e9eb5(0x130),'js',_0x2e9eb5(0x125),_0x2e9eb5(0x127),_0x2e9eb5(0x147),'py','java',_0x2e9eb5(0x13b),'c','h',_0x2e9eb5(0x154),'sh'][_0x2e9eb5(0x12b)](ext))return'file-type-code';if([_0x2e9eb5(0x151),'rar','7z','tar','gz',_0x2e9eb5(0x14a)]['includes'](ext))return'file-type-archives';if(['csv',_0x2e9eb5(0x13d),'md',_0x2e9eb5(0x145),_0x2e9eb5(0x128),_0x2e9eb5(0x132),_0x2e9eb5(0x12a)][_0x2e9eb5(0x12b)](ext))return _0x2e9eb5(0x14f);}function _0x152c(_0x5eaf69,_0x3ade1){const _0x149d11=_0x149d();return _0x152c=function(_0x152cc2,_0x16954e){_0x152cc2=_0x152cc2-0x125;let _0x44c594=_0x149d11[_0x152cc2];return _0x44c594;},_0x152c(_0x5eaf69,_0x3ade1);}function _0x149d(){const _0x415778=['yaml','type','conf','includes','file-type-videos','bmp','avi','xlsx','css','ppt','ini','65458xJokHY','docx','81627OvIQus','file-type-images','doc','ico','toLowerCase','2659662HAkCwQ','cpp','6hRSiji','log','odp','wma','16895862jydAZS','file-type-audio','file-type-default','xls','extension','yml','odt','php','3gp','folder','bz2','folder-icon','ogg','mp4','file-type-documents','file-type-other','wav','zip','html','686855NHeaIz','sql','392ZtKvba','mp3','mov','ods','pptx','1410220MffrzE','jpeg','wmv','file-type-','category','1200524qxsJuc','flac','mkv','json','rtf','xml'];_0x149d=function(){return _0x415778;};return _0x149d();}return _0x2e9eb5(0x142);
        }

        isImageFile(item) {
            function _0x25bb(_0x2009ad,_0x187a83){const _0x4f4f63=_0x4f4f();return _0x25bb=function(_0x25bbf1,_0x20de00){_0x25bbf1=_0x25bbf1-0x16a;let _0x290af6=_0x4f4f63[_0x25bbf1];return _0x290af6;},_0x25bb(_0x2009ad,_0x187a83);}const _0x33b9a2=_0x25bb;function _0x4f4f(){const _0x11a5ab=['31328OYSRKH','4687458LyMupI','svg','8279390WKoGsW','png','237jwSPxU','4897340snPldd','extension','738ULAodQ','25627041yWnJCY','webp','toLowerCase','gif','7zVbFek','jpg','5816MavEOv','486IItRJM','1454kwMUJx','category','includes'];_0x4f4f=function(){return _0x11a5ab;};return _0x4f4f();}(function(_0x4e9e3a,_0x4f0b8d){const _0x92cdbb=_0x25bb,_0x4d148d=_0x4e9e3a();while(!![]){try{const _0x304862=parseInt(_0x92cdbb(0x17a))/0x1*(parseInt(_0x92cdbb(0x171))/0x2)+-parseInt(_0x92cdbb(0x16e))/0x3*(-parseInt(_0x92cdbb(0x178))/0x4)+-parseInt(_0x92cdbb(0x16f))/0x5+-parseInt(_0x92cdbb(0x16a))/0x6*(parseInt(_0x92cdbb(0x176))/0x7)+parseInt(_0x92cdbb(0x17d))/0x8*(parseInt(_0x92cdbb(0x179))/0x9)+-parseInt(_0x92cdbb(0x16c))/0xa+parseInt(_0x92cdbb(0x172))/0xb;if(_0x304862===_0x4f0b8d)break;else _0x4d148d['push'](_0x4d148d['shift']());}catch(_0x41787c){_0x4d148d['push'](_0x4d148d['shift']());}}}(_0x4f4f,0x93721));if(item[_0x33b9a2(0x17b)]==='images')return!![];if(item[_0x33b9a2(0x170)]){const ext=item['extension'][_0x33b9a2(0x174)]();return[_0x33b9a2(0x177),'jpeg',_0x33b9a2(0x16d),_0x33b9a2(0x175),_0x33b9a2(0x173),_0x33b9a2(0x16b)][_0x33b9a2(0x17c)](ext);}return![];
        }

        updateBreadcrumb(currentPath) {
           const _0x24b3c1=_0x2b4a;(function(_0x14a73f,_0x2f9919){const _0x25af3c=_0x2b4a,_0x28f6b0=_0x14a73f();while(!![]){try{const _0x4ba6b6=-parseInt(_0x25af3c(0x13c))/0x1*(-parseInt(_0x25af3c(0x14a))/0x2)+-parseInt(_0x25af3c(0x144))/0x3*(parseInt(_0x25af3c(0x14c))/0x4)+parseInt(_0x25af3c(0x149))/0x5+parseInt(_0x25af3c(0x139))/0x6+-parseInt(_0x25af3c(0x13a))/0x7*(parseInt(_0x25af3c(0x141))/0x8)+parseInt(_0x25af3c(0x13b))/0x9+parseInt(_0x25af3c(0x14d))/0xa;if(_0x4ba6b6===_0x2f9919)break;else _0x28f6b0['push'](_0x28f6b0['shift']());}catch(_0x4d2b51){_0x28f6b0['push'](_0x28f6b0['shift']());}}}(_0x5c1d,0xa5241));const breadcrumb=$(_0x24b3c1(0x146));function _0x2b4a(_0x308ed1,_0x5a92be){const _0x5c1ddc=_0x5c1d();return _0x2b4a=function(_0x2b4a94,_0x18d1ea){_0x2b4a94=_0x2b4a94-0x139;let _0x10d358=_0x5c1ddc[_0x2b4a94];return _0x10d358;},_0x2b4a(_0x308ed1,_0x5a92be);}breadcrumb[_0x24b3c1(0x145)](),breadcrumb['append'](_0x24b3c1(0x13f));const goBackBtn=$('#goBackBtn');currentPath&&currentPath!==''?goBackBtn[_0x24b3c1(0x13e)](_0x24b3c1(0x143),![]):goBackBtn[_0x24b3c1(0x13e)](_0x24b3c1(0x143),!![]);function _0x5c1d(){const _0x44491f=['3olxQTY','empty','#breadcrumb','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<li\x20class=\x22breadcrumb-item\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<a\x20href=\x22#\x22\x20data-path=\x22','</a>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</li>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','1592145moyFNf','2ThZqeY','append','5008592oYSPIg','14259840lFSoZM','225954CPSQoV','49Kyruez','11131713AQpjxe','23763YfgLUw','length','prop','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<li\x20class=\x22breadcrumb-item\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<a\x20href=\x22#\x22\x20data-path=\x22\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fa\x20fa-home\x22></i>\x20Root\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</a>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</li>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','</li>','1273288zuzqGu','<li\x20class=\x22breadcrumb-item\x20active\x22>','disabled'];_0x5c1d=function(){return _0x44491f;};return _0x5c1d();}if(currentPath){const parts=currentPath['split']('/');let buildPath='';parts['forEach']((_0x4884c8,_0x3ef4c4)=>{const _0x892d9f=_0x24b3c1;buildPath+=(_0x3ef4c4>0x0?'/':'')+_0x4884c8;const _0x5b27f7=_0x3ef4c4===parts[_0x892d9f(0x13d)]-0x1;_0x5b27f7?breadcrumb[_0x892d9f(0x14b)](_0x892d9f(0x142)+_0x4884c8+_0x892d9f(0x140)):breadcrumb[_0x892d9f(0x14b)](_0x892d9f(0x147)+buildPath+'\x22>'+_0x4884c8+_0x892d9f(0x148));});}
        }

        navigateTo(path) {
            this.loadFiles(path);
        }

        goBack() {
            function _0xf867(){const _0x3906b5=['2372dcYWfy','120lBtdPU','603fZbLAl','538488Isujel','339856SBVZNX','31884ipcAlU','currentPath','join','913654ehWmkN','852759IESHYs','120590BWgjVF','split'];_0xf867=function(){return _0x3906b5;};return _0xf867();}function _0x8b04(_0x5a4af1,_0x1a12e5){const _0xf867bc=_0xf867();return _0x8b04=function(_0x8b0486,_0x127ee9){_0x8b0486=_0x8b0486-0x117;let _0x457310=_0xf867bc[_0x8b0486];return _0x457310;},_0x8b04(_0x5a4af1,_0x1a12e5);}const _0x5d214f=_0x8b04;(function(_0x20f9d8,_0x196b79){const _0x25db63=_0x8b04,_0x2dd4ab=_0x20f9d8();while(!![]){try{const _0xfd6f09=-parseInt(_0x25db63(0x122))/0x1+parseInt(_0x25db63(0x118))/0x2*(parseInt(_0x25db63(0x11a))/0x3)+-parseInt(_0x25db63(0x11c))/0x4+parseInt(_0x25db63(0x119))/0x5*(parseInt(_0x25db63(0x11d))/0x6)+parseInt(_0x25db63(0x120))/0x7+-parseInt(_0x25db63(0x11b))/0x8+-parseInt(_0x25db63(0x121))/0x9;if(_0xfd6f09===_0x196b79)break;else _0x2dd4ab['push'](_0x2dd4ab['shift']());}catch(_0x247ebb){_0x2dd4ab['push'](_0x2dd4ab['shift']());}}}(_0xf867,0x1f73c));if(this[_0x5d214f(0x11e)]&&this[_0x5d214f(0x11e)]!==''){const pathParts=this['currentPath'][_0x5d214f(0x117)]('/');pathParts['pop']();const parentPath=pathParts[_0x5d214f(0x11f)]('/');this['navigateTo'](parentPath);}
        }

        async createFolder() {
            function _0x35c0(_0x2b6503,_0x4194c0){const _0x317a53=_0x317a();return _0x35c0=function(_0x35c0e1,_0x486971){_0x35c0e1=_0x35c0e1-0x65;let _0x35f1ad=_0x317a53[_0x35c0e1];return _0x35f1ad;},_0x35c0(_0x2b6503,_0x4194c0);}const _0x29a6c2=_0x35c0;(function(_0x416161,_0x1e666e){const _0x32c38f=_0x35c0,_0x8feb87=_0x416161();while(!![]){try{const _0xbbb739=-parseInt(_0x32c38f(0x6a))/0x1+parseInt(_0x32c38f(0x6e))/0x2*(-parseInt(_0x32c38f(0x6d))/0x3)+parseInt(_0x32c38f(0x67))/0x4*(parseInt(_0x32c38f(0x72))/0x5)+-parseInt(_0x32c38f(0x65))/0x6*(-parseInt(_0x32c38f(0x69))/0x7)+-parseInt(_0x32c38f(0x73))/0x8*(parseInt(_0x32c38f(0x71))/0x9)+parseInt(_0x32c38f(0x70))/0xa*(-parseInt(_0x32c38f(0x6f))/0xb)+parseInt(_0x32c38f(0x66))/0xc;if(_0xbbb739===_0x1e666e)break;else _0x8feb87['push'](_0x8feb87['shift']());}catch(_0x4205b1){_0x8feb87['push'](_0x8feb87['shift']());}}}(_0x317a,0x8b7ec));const name=$(_0x29a6c2(0x68))['val']();function _0x317a(){const _0x15f6f9=['102555HtQATZ','error','Please\x20enter\x20folder\x20name','3180111ANuotp','2hxHHTP','11336765TJWhjX','10JInxmg','9401517IKeriw','12235bTXHlX','8wPRqzT','694698HSQflN','32783856IGAuNE','436YoFoQh','#createFolderForm\x20input[name=\x22name\x22]','49BjraTm'];_0x317a=function(){return _0x15f6f9;};return _0x317a();}if(!name['trim']()){this['showMessage'](_0x29a6c2(0x6b),_0x29a6c2(0x6c));return;}

            try {
                console.log('Creating folder:', name, 'in path:', this.currentPath);
                const response = await $.post('{{ route("admin.filemanager.create-folder") }}', {
                    name: name,
                    path: this.currentPath,
                    _token: $('meta[name="csrf-token"]').attr('content')
                });

                function _0x37aa(_0x1c7b68,_0x5385d0){var _0x7b52fd=_0x7b52();return _0x37aa=function(_0x37aa88,_0x2a6a06){_0x37aa88=_0x37aa88-0x70;var _0xb5e8d3=_0x7b52fd[_0x37aa88];return _0xb5e8d3;},_0x37aa(_0x1c7b68,_0x5385d0);}var _0x5424a7=_0x37aa;function _0x7b52(){var _0x1a67c5=['#createFolderForm','7199956hkhIre','3HgRaEz','4895owAWYr','#createFolderModal','1012255rmmzTj','reset','modal','log','11982lWMdkM','showMessage','Folder\x20created\x20successfully!','3096709tQbDXc','81616bkHnRw','130EepmkJ','311546DyBeqx','success','369bBsVSg','hide','4977874Jijizc'];_0x7b52=function(){return _0x1a67c5;};return _0x7b52();}(function(_0x17009c,_0x49b4cb){var _0x24f3bf=_0x37aa,_0x176113=_0x17009c();while(!![]){try{var _0x36f941=-parseInt(_0x24f3bf(0x7a))/0x1+parseInt(_0x24f3bf(0x70))/0x2*(-parseInt(_0x24f3bf(0x77))/0x3)+-parseInt(_0x24f3bf(0x76))/0x4+-parseInt(_0x24f3bf(0x78))/0x5*(parseInt(_0x24f3bf(0x7e))/0x6)+parseInt(_0x24f3bf(0x81))/0x7+-parseInt(_0x24f3bf(0x82))/0x8*(parseInt(_0x24f3bf(0x72))/0x9)+-parseInt(_0x24f3bf(0x83))/0xa*(-parseInt(_0x24f3bf(0x74))/0xb);if(_0x36f941===_0x49b4cb)break;else _0x176113['push'](_0x176113['shift']());}catch(_0x3e3ee1){_0x176113['push'](_0x176113['shift']());}}}(_0x7b52,0xf039f),console[_0x5424a7(0x7d)]('Create\x20folder\x20response:',response),this[_0x5424a7(0x7f)](_0x5424a7(0x71),_0x5424a7(0x80)),$(_0x5424a7(0x79))[_0x5424a7(0x7c)](_0x5424a7(0x73)),$(_0x5424a7(0x75))[0x0][_0x5424a7(0x7b)]());
                
                setTimeout(() => {
                    this.loadFiles(this.currentPath);
                }, 500);
            } catch (error) {
                function _0x3bbf(_0x4ce0bc,_0x29c894){var _0x150496=_0x1504();return _0x3bbf=function(_0x3bbf79,_0x76b1b){_0x3bbf79=_0x3bbf79-0x16b;var _0x4d969c=_0x150496[_0x3bbf79];return _0x4d969c;},_0x3bbf(_0x4ce0bc,_0x29c894);}var _0x2be061=_0x3bbf;(function(_0x33416e,_0x74d339){var _0x56a24f=_0x3bbf,_0x34bcbe=_0x33416e();while(!![]){try{var _0x13bfc3=-parseInt(_0x56a24f(0x179))/0x1+-parseInt(_0x56a24f(0x176))/0x2*(parseInt(_0x56a24f(0x16c))/0x3)+-parseInt(_0x56a24f(0x177))/0x4*(parseInt(_0x56a24f(0x174))/0x5)+-parseInt(_0x56a24f(0x16f))/0x6+-parseInt(_0x56a24f(0x170))/0x7*(parseInt(_0x56a24f(0x16d))/0x8)+parseInt(_0x56a24f(0x171))/0x9+parseInt(_0x56a24f(0x16e))/0xa;if(_0x13bfc3===_0x74d339)break;else _0x34bcbe['push'](_0x34bcbe['shift']());}catch(_0x1445ac){_0x34bcbe['push'](_0x34bcbe['shift']());}}}(_0x1504,0x35386),console['error'](_0x2be061(0x175),error),this[_0x2be061(0x178)]('error',_0x2be061(0x17a)+(error[_0x2be061(0x172)]?.[_0x2be061(0x173)]||_0x2be061(0x16b))));function _0x1504(){var _0x49b804=['error','30JEFBah','Create\x20folder\x20error:','2dzuwkl','184028nMRPTf','showMessage','39598NmbVqn','Error:\x20','Failed\x20to\x20create\x20folder','373371VVAvVi','33272MWzwNh','6964120NIolkE','1530840wcndvl','308btJjdQ','3598299MwGCDR','responseJSON'];_0x1504=function(){return _0x49b804;};return _0x1504();}
            }
        }

        showLoading(show) {
            function _0x4383(_0x5df04e,_0x1c42bf){var _0xa3822f=_0xa382();return _0x4383=function(_0x4383ab,_0x2aa252){_0x4383ab=_0x4383ab-0x137;var _0x5b2959=_0xa3822f[_0x4383ab];return _0x5b2959;},_0x4383(_0x5df04e,_0x1c42bf);}var _0x51351e=_0x4383;function _0xa382(){var _0x2b099a=['d-none','hide','addClass','show','4240443AWHuPD','5190039GfqfIR','#listView','377192eUhroY','4042130RnWPAe','1241653OubwOB','2eHeRaN','#emptyState','5288778Ajtjie','#loadingIndicator','4333252AJZHow','24iGzYQE'];_0xa382=function(){return _0x2b099a;};return _0xa382();}(function(_0x3fed4d,_0x28bd32){var _0x403bd2=_0x4383,_0x20d751=_0x3fed4d();while(!![]){try{var _0x196c6b=parseInt(_0x403bd2(0x13d))/0x1+-parseInt(_0x403bd2(0x140))/0x2*(-parseInt(_0x403bd2(0x13a))/0x3)+-parseInt(_0x403bd2(0x144))/0x4+-parseInt(_0x403bd2(0x13e))/0x5+parseInt(_0x403bd2(0x142))/0x6+parseInt(_0x403bd2(0x13f))/0x7*(-parseInt(_0x403bd2(0x145))/0x8)+parseInt(_0x403bd2(0x13b))/0x9;if(_0x196c6b===_0x28bd32)break;else _0x20d751['push'](_0x20d751['shift']());}catch(_0x5b6760){_0x20d751['push'](_0x20d751['shift']());}}}(_0xa382,0xc9663));show?($('#loadingIndicator')[_0x51351e(0x139)](),$('#gridView')[_0x51351e(0x138)](_0x51351e(0x146)),$(_0x51351e(0x13c))[_0x51351e(0x138)]('d-none'),$(_0x51351e(0x141))[_0x51351e(0x138)](_0x51351e(0x146))):$(_0x51351e(0x143))[_0x51351e(0x137)]();
        }
    }

    $(document).ready(() => {
        window.testFileManager = new TestFileManager();

       const _0x3fb847=_0x417a;function _0x417a(_0x30dc73,_0x2bfa61){const _0x3c7727=_0x3c77();return _0x417a=function(_0x417af1,_0x2cbb3b){_0x417af1=_0x417af1-0x151;let _0x3530f4=_0x3c7727[_0x417af1];return _0x3530f4;},_0x417a(_0x30dc73,_0x2bfa61);}function _0x3c77(){const _0x358721=['7973LacPgi','19830hHUPQa','521460iWEjAK','10022etrJxl','search','23ePnZBA','3302912uztISx','get','8030dLEiqO','277605OrRCuT','24wtqSuU','1754697RSdQOW','file_type','3510hrFOjc'];_0x3c77=function(){return _0x358721;};return _0x3c77();}(function(_0x58659a,_0x1f47bd){const _0x32fe6e=_0x417a,_0xa5e5de=_0x58659a();while(!![]){try{const _0x23c9ff=-parseInt(_0x32fe6e(0x15a))/0x1*(parseInt(_0x32fe6e(0x158))/0x2)+-parseInt(_0x32fe6e(0x152))/0x3+-parseInt(_0x32fe6e(0x151))/0x4*(parseInt(_0x32fe6e(0x157))/0x5)+parseInt(_0x32fe6e(0x154))/0x6*(parseInt(_0x32fe6e(0x155))/0x7)+-parseInt(_0x32fe6e(0x15b))/0x8+-parseInt(_0x32fe6e(0x15e))/0x9+-parseInt(_0x32fe6e(0x156))/0xa*(-parseInt(_0x32fe6e(0x15d))/0xb);if(_0x23c9ff===_0x1f47bd)break;else _0xa5e5de['push'](_0xa5e5de['shift']());}catch(_0x34bf18){_0xa5e5de['push'](_0xa5e5de['shift']());}}}(_0x3c77,0x540e4));const urlParams=new URLSearchParams(window['location'][_0x3fb847(0x159)]),selectMode=urlParams[_0x3fb847(0x15c)]('select_mode'),fileType=urlParams[_0x3fb847(0x15c)](_0x3fb847(0x153)),inputId=urlParams[_0x3fb847(0x15c)]('input_id');

        const _0x53252a=_0x4db9;function _0x4db9(_0x489d12,_0x19e2bb){const _0x5b0fca=_0x5b0f();return _0x4db9=function(_0x4db951,_0x15a20a){_0x4db951=_0x4db951-0x1c3;let _0x171a1=_0x5b0fca[_0x4db951];return _0x171a1;},_0x4db9(_0x489d12,_0x19e2bb);}(function(_0x2768cd,_0x6d0127){const _0x449ace=_0x4db9,_0x2e151f=_0x2768cd();while(!![]){try{const _0x288b67=parseInt(_0x449ace(0x1e1))/0x1*(-parseInt(_0x449ace(0x1d7))/0x2)+parseInt(_0x449ace(0x1e4))/0x3*(parseInt(_0x449ace(0x1ca))/0x4)+-parseInt(_0x449ace(0x1cc))/0x5+parseInt(_0x449ace(0x1d8))/0x6+parseInt(_0x449ace(0x1cd))/0x7+-parseInt(_0x449ace(0x1d3))/0x8*(-parseInt(_0x449ace(0x1ce))/0x9)+-parseInt(_0x449ace(0x1db))/0xa;if(_0x288b67===_0x6d0127)break;else _0x2e151f['push'](_0x2e151f['shift']());}catch(_0x38214b){_0x2e151f['push'](_0x2e151f['shift']());}}}(_0x5b0f,0x99d3a));function _0x5b0f(){const _0x3eefe2=['close','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<button\x20type=\x22button\x22\x20class=\x22btn\x20btn-modern\x20btn-primary-modern\x22\x20id=\x22selectFileBtn\x22\x20disabled>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<i\x20class=\x22fa\x20fa-check\x22></i>\x20Select\x20File\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</button>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20.selected-for-use\x20{\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20border:\x203px\x20solid\x20#007bff\x20!important;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20background-color:\x20#e7f3ff\x20!important;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20}\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20.selected-for-use\x20.file-name\x20{\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20color:\x20#007bff\x20!important;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-weight:\x20bold\x20!important;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20}\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','34ZXvbQa','click','type','89472uDYzTa','prop','.btn-group-modern','head','appendTo','selected-for-use','opener','addClass','text','48pHISyB','postMessage','3008505rFYwXn','2887234vDziEW','146835tqixpi','#selectFileBtn','fileSelected','removeClass','.file-card','520vUXzmA','selectedFilePath','path','stopPropagation','47020XMqmBL','1217532tUCDll','data','after','26320STlctJ','<div\x20class=\x22alert\x20alert-info\x20mt-2\x22><i\x20class=\x22fa\x20fa-info-circle\x22></i>\x20Selection\x20Mode:\x20Click\x20on\x20a\x20file\x20to\x20select\x20it</div>','dispatchEvent'];_0x5b0f=function(){return _0x3eefe2;};return _0x5b0f();}selectMode==='true'&&($('.header-title')[_0x53252a(0x1da)](_0x53252a(0x1dc)),$(_0x53252a(0x1c3))['append'](_0x53252a(0x1df)),$(document)['on'](_0x53252a(0x1e2),_0x53252a(0x1d2),function(_0x2a54eb){const _0x2d6693=_0x53252a;$(this)[_0x2d6693(0x1d9)](_0x2d6693(0x1e3))==='file'&&(_0x2a54eb['preventDefault'](),_0x2a54eb[_0x2d6693(0x1d6)](),$(_0x2d6693(0x1d2))[_0x2d6693(0x1d1)]('selected-for-use'),$(this)[_0x2d6693(0x1c8)](_0x2d6693(0x1c6)),$(_0x2d6693(0x1cf))[_0x2d6693(0x1e5)]('disabled',![]),window[_0x2d6693(0x1d4)]=$(this)[_0x2d6693(0x1d9)](_0x2d6693(0x1d5)));}),$(document)['on']('click',_0x53252a(0x1cf),function(){const _0x37397c=_0x53252a;if(window['selectedFilePath']&&inputId){if(window[_0x37397c(0x1c7)]){window[_0x37397c(0x1c7)][_0x37397c(0x1cb)]({'type':_0x37397c(0x1d0),'filePath':window[_0x37397c(0x1d4)],'inputId':inputId},'*');const _0x2c3f86=new CustomEvent(_0x37397c(0x1d0),{'detail':{'filePath':window[_0x37397c(0x1d4)],'inputId':inputId}});window[_0x37397c(0x1c7)][_0x37397c(0x1dd)](_0x2c3f86);}window[_0x37397c(0x1de)]();}}),$('<style>')[_0x53252a(0x1c9)](_0x53252a(0x1e0))[_0x53252a(0x1c5)](_0x53252a(0x1c4)));
    });
    </script>
@endsection
