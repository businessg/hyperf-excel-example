<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Demo - 导入导出示例</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 32px;
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin-bottom: 28px;
            color: #1a1a1a;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        h1::before {
            content: '📊';
            font-size: 32px;
        }

        .export-config-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .config-selectors {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .selector-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .selector-group label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .config-select {
            padding: 8px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 180px;
        }

        .config-select:hover {
            border-color: #667eea;
        }

        .config-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .code-display-section {
            background: #1e1e1e;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .code-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #252526;
            border-bottom: 1px solid #3e3e42;
        }

        .code-header span {
            font-size: 14px;
            font-weight: 600;
            color: #cccccc;
        }

        .btn-copy {
            background: #007acc;
            color: white;
            border: none;
            padding: 4px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .btn-copy:hover {
            background: #005a9e;
        }

        .code-block {
            margin: 0;
            padding: 16px;
            background: #1e1e1e;
            color: #d4d4d4;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }

        .code-block code {
            display: block;
            white-space: pre;
        }

        .code-block::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .code-block::-webkit-scrollbar-track {
            background: #252526;
        }

        .code-block::-webkit-scrollbar-thumb {
            background: #424242;
            border-radius: 4px;
        }

        .code-block::-webkit-scrollbar-thumb:hover {
            background: #4e4e4e;
        }

        .toolbar {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(17, 153, 142, 0.4);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        th:first-child {
            border-top-left-radius: 8px;
        }

        th:last-child {
            border-top-right-radius: 8px;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        td {
            color: #555;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 0;
            width: 90%;
            max-width: 700px;
            max-height: 95vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 24px 24px 16px 24px;
        }

        .modal-body {
            flex: 1 1 auto;
            overflow: visible;
            overflow-x: hidden;
            padding: 16px 20px;
            min-height: 0;
            display: flex;
            flex-direction: column;
            background: #fafbfc;
        }

        .modal-footer {
            flex-shrink: 0;
            padding: 12px 20px;
            border-top: 2px solid #f0f0f0;
            text-align: center;
            margin-top: 0;
            min-height: 50px;
            box-sizing: border-box;
            background: white;
        }

        .message-container::-webkit-scrollbar {
            width: 6px;
        }

        .message-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .message-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .message-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
            padding: 16px 24px 12px 24px;
            border-bottom: 2px solid #f0f0f0;
            flex-shrink: 0;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .close {
            background: #f5f5f5;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            line-height: 1;
        }

        .close:hover {
            background: #e8e8e8;
            color: #333;
            transform: rotate(90deg);
        }

        .progress-container {
            margin: 0 0 12px 0;
            min-height: 40px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            background: white;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: visible;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e8e8e8;
            border-radius: 10px;
            overflow: visible;
            margin-bottom: 0;
            display: block;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0%;
            display: block;
            min-width: 0;
            border-radius: 10px;
            position: absolute;
            top: 0;
            left: 0;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
            z-index: 1;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10px;
            color: #1a1a1a;
            display: block;
            line-height: 1;
            font-weight: 700;
            z-index: 2;
            white-space: nowrap;
            text-transform: lowercase;
            pointer-events: none;
            text-shadow: 
                0 0 4px rgba(255, 255, 255, 1),
                0 0 8px rgba(255, 255, 255, 0.9),
                0 1px 2px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.3px;
        }

        .progress-info {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin: 10px 0 0 0;
            padding: 12px;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 10px;
            min-height: 55px;
            flex-shrink: 0;
            visibility: visible;
            opacity: 1;
            border: 1px solid #e8e8e8;
            overflow: visible;
        }

        .progress-bar-wrapper {
            grid-column: 1 / -1;
            margin-bottom: 8px;
        }

        .progress-info-item {
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            min-height: 50px;
            padding: 6px;
            background: white;
            border-radius: 8px;
            visibility: visible;
            opacity: 1;
            transition: all 0.2s ease;
            border: 1px solid #f0f0f0;
            min-width: 0;
            overflow: hidden;
        }

        .progress-info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #667eea;
        }

        .progress-info-label {
            font-size: 10px;
            color: #888;
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .progress-info-value {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
            display: block;
            visibility: visible;
            opacity: 1;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .progress-info-value.status {
            font-size: 13px;
            font-weight: 600;
        }

        .status-1 { color: #999; }
        .status-2 { color: #667eea; }
        .status-3 { color: #38ef7d; }
        .status-4 { color: #ff6b6b; }
        .status-5 { color: #ffd93d; }
        .status-6 { color: #38ef7d; }

        .message-container {
            margin: 0;
            max-height: 180px;
            min-height: 80px;
            overflow-y: auto;
            overflow-x: hidden;
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            padding: 12px;
            background: white;
            flex-shrink: 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .message-item {
            padding: 6px 10px;
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
            border-radius: 6px;
            background: #f8f9ff;
            border-left: 3px solid #667eea;
            transition: all 0.2s ease;
        }

        .message-item:hover {
            background: #f0f2ff;
            transform: translateX(4px);
        }

        .message-item.error {
            color: #ff6b6b;
            background: #fff5f5;
            border-left-color: #ff6b6b;
        }

        .message-item.error:hover {
            background: #ffe8e8;
        }

        .message-item.success {
            color: #38ef7d;
            background: #f0fff4;
            border-left-color: #38ef7d;
        }

        .message-item.success:hover {
            background: #e8fef0;
        }

        .action-buttons {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            gap: 10px;
            z-index: 10;
            align-items: center;
        }

        .action-buttons .download-template-link {
            flex-shrink: 0;
        }

        .action-buttons .btn {
            flex-shrink: 0;
            padding: 6px 16px;
            font-size: 13px;
        }

        .download-template-link {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border: 1px solid #e0e7ff;
        }

        .download-template-link:hover {
            color: #764ba2;
            background: linear-gradient(135deg, #f0f2ff 0%, #f8f9ff 100%);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        .download-template-link:active {
            transform: translateY(0);
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            border: 2px dashed #d9d9d9;
            border-radius: 12px;
            padding: 50px 16px 24px 16px;
            text-align: center;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            margin: 0 0 12px 0;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .file-input-wrapper:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .file-input-wrapper.drag-over {
            border-color: #667eea;
            background: linear-gradient(135deg, #e6f0ff 0%, #f0f7ff 100%);
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .file-input {
            position: absolute;
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
        }

        .file-input-icon {
            font-size: 40px;
            color: #d9d9d9;
            margin-bottom: 8px;
            line-height: 1;
            transition: all 0.3s ease;
        }

        .file-input-wrapper:hover .file-input-icon,
        .file-input-wrapper.drag-over .file-input-icon {
            color: #667eea;
            transform: scale(1.1);
        }

        .file-input-text {
            font-size: 13px;
            color: #666;
            margin-bottom: 2px;
        }

        .file-input-hint {
            font-size: 11px;
            color: #999;
        }

        .file-name {
            margin-top: 12px;
            font-size: 13px;
            color: #667eea;
            word-break: break-all;
            padding: 8px 12px;
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
            border-radius: 8px;
            border: 1px solid #e0e7ff;
            font-weight: 500;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 20px;
                border-radius: 8px;
            }

            h1 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                padding: 12px 20px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px 8px;
            }

            .modal-content {
                width: 95%;
                max-width: none;
                border-radius: 12px;
            }

            .modal-header {
                padding: 20px;
            }

            .modal-body {
                padding: 20px;
            }

            .modal-footer {
                padding: 16px 20px;
            }

            .progress-info {
                grid-template-columns: repeat(5, 1fr);
                gap: 8px;
                padding: 12px;
            }

            .progress-bar-wrapper {
                grid-column: 1 / -1;
            }

            .progress-info-item {
                min-height: 50px;
                padding: 6px;
            }

            .progress-info-value {
                font-size: 16px;
            }

            .progress-info-label {
                font-size: 10px;
            }

            .file-input-wrapper {
                padding: 24px 16px;
            }

            .file-input-icon {
                font-size: 36px;
            }
        }

        @media (max-width: 480px) {
            .progress-info {
                grid-template-columns: repeat(5, 1fr);
                gap: 6px;
                padding: 10px;
            }

            .progress-info-item {
                min-height: 45px;
                padding: 4px;
            }

            .progress-info-value {
                font-size: 14px;
            }

            .progress-info-label {
                font-size: 9px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Excel 导入导出 Demo</h1>
        
        <?php
        // 代码示例数据（存储在PHP变量中，避免解析错误）
        $codeExamples = [
            'xlswriter' => file_get_contents(__DIR__ . '/../../Excel/Export/DemoXlsWriterExportConfig.php'),
            'spreadsheet' => file_get_contents(__DIR__ . '/../../Excel/Export/DemoSpreadSheetDriverExportConfig.php'),
        ];
        ?>
        
        <div class="export-config-section">
            <div class="config-selectors">
                <div class="selector-group">
                    <label for="driverSelect">选择驱动：</label>
                    <select id="driverSelect" class="config-select" onchange="updateCodeDisplay()">
                        <option value="xlswriter">XlsWriter</option>
                        <option value="spreadsheet">SpreadSheet</option>
                    </select>
                </div>
                <button class="btn btn-primary" onclick="startExportWithConfig()">导出数据</button>
                <button class="btn btn-success" onclick="openImportModal()">导入数据</button>
            </div>
            
            <div class="code-display-section">
                <div class="code-header">
                    <span>导出配置代码</span>
                    <button class="btn-copy" onclick="copyCode()" title="复制代码">📋</button>
                </div>
                <pre id="codeDisplay" class="code-block"><code id="codeContent"></code></pre>
            </div>
        </div>
    </div>

    <!-- 导出弹窗 -->
    <div id="exportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">导出数据</div>
                <button class="close" onclick="closeExportModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="progress-info" id="exportProgressInfo">
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar">
                            <div class="progress-fill" id="exportProgressFill"></div>
                            <div class="progress-text" id="exportProgressText">准备中...</div>
                        </div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">总数</div>
                        <div class="progress-info-value" id="exportTotal">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">进度</div>
                        <div class="progress-info-value" id="exportProgress">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">成功数</div>
                        <div class="progress-info-value" id="exportSuccess">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">失败数</div>
                        <div class="progress-info-value" id="exportFail">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">状态</div>
                        <div class="progress-info-value status" id="exportStatus">待处理</div>
                    </div>
                </div>
                <div class="message-container" id="exportMessages"></div>
            </div>
            <div class="modal-footer" id="exportDownloadArea" style="visibility: hidden;">
                <button class="btn btn-primary" id="exportDownloadBtn" onclick="downloadExportFile()">下载文件</button>
            </div>
        </div>
    </div>

    <!-- 导入弹窗 -->
    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">导入数据</div>
                <button class="close" onclick="closeImportModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="progress-info" id="importProgressInfo">
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar">
                            <div class="progress-fill" id="importProgressFill"></div>
                            <div class="progress-text" id="importProgressText">等待上传...</div>
                        </div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">总数</div>
                        <div class="progress-info-value" id="importTotal">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">进度</div>
                        <div class="progress-info-value" id="importProgress">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">成功数</div>
                        <div class="progress-info-value" id="importSuccess">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">失败数</div>
                        <div class="progress-info-value" id="importFail">0</div>
                    </div>
                    <div class="progress-info-item">
                        <div class="progress-info-label">状态</div>
                        <div class="progress-info-value status" id="importStatus">待处理</div>
                    </div>
                </div>
                <div class="file-input-wrapper" id="fileInputWrapper" 
                     ondrop="handleFileDrop(event)" 
                     ondragover="handleDragOver(event)" 
                     ondragleave="handleDragLeave(event)">
                    <div class="action-buttons">
                        <a href="javascript:void(0)" class="download-template-link" onclick="downloadTemplate()">下载模板</a>
                        <button class="btn btn-success" onclick="startImport()">开始导入</button>
                    </div>
                    <input type="file" id="importFile" class="file-input" accept=".xlsx,.xls" onchange="handleFileSelect(this)">
                    <label for="importFile" class="file-input-label">
                        <span class="file-input-icon">📁</span>
                        <span class="file-input-text">点击选择文件或拖拽文件到此处</span>
                        <span class="file-input-hint">支持 .xlsx, .xls 格式</span>
                    </label>
                    <div class="file-name" id="importFileName"></div>
                </div>
                <div class="message-container" id="importMessages"></div>
            </div>
        </div>
    </div>

    <script>
        // 配置信息
        const config = {
            // 导出下载域名
            exportDownloadDomain: window.location.origin + '/upload',
            // 上传文件域名
            uploadDomain: window.location.origin + '/upload'
        };
        
        const API_BASE = '/excel';
        let exportToken = null;
        let importToken = null;
        let exportProgressInterval = null; // 导出进度轮询
        let exportMessageInterval = null; // 导出消息轮询
        let importProgressInterval = null; // 导入进度轮询
        let importMessageInterval = null; // 导入消息轮询
        let exportDownloadUrl = null; // 保存导出文件的下载地址

        // 代码示例映射（从PHP变量中获取）
        const codeExamples = <?php echo json_encode($codeExamples, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

            // 业务ID映射
            const businessIdMap = {
                'xlswriter': 'demoXlsWriterExport',
                'spreadsheet': 'demoSpreadSheetExport'
            };

            // 更新代码显示
            function updateCodeDisplay() {
                const driver = document.getElementById('driverSelect').value;
                const code = codeExamples[driver] || '';
                document.getElementById('codeContent').textContent = code;
            }

            // 根据配置开始导出
            function startExportWithConfig() {
                const driver = document.getElementById('driverSelect').value;
                const businessId = businessIdMap[driver];
                
                if (businessId) {
                    openExportModal(businessId);
                } else {
                    alert('未找到对应的导出配置');
                }
            }

        // 复制代码
        function copyCode() {
            const codeContentEl = document.getElementById('codeContent');
            if (!codeContentEl) {
                alert('代码内容不存在');
                return;
            }
            
            const codeContent = codeContentEl.textContent || codeContentEl.innerText || '';
            if (!codeContent.trim()) {
                alert('代码内容为空');
                return;
            }
            
            const btn = document.querySelector('.btn-copy');
            const originalText = btn ? btn.textContent : '📋';
            
            // 优先使用现代 Clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(codeContent).then(() => {
                    if (btn) {
                        btn.textContent = '✓ 已复制';
                        btn.style.background = '#28a745';
                        setTimeout(() => {
                            btn.textContent = originalText;
                            btn.style.background = '#007acc';
                        }, 2000);
                    }
                }).catch(err => {
                    console.error('复制失败:', err);
                    // 如果Clipboard API失败，尝试使用传统方法
                    fallbackCopyTextToClipboard(codeContent, btn, originalText);
                });
            } else {
                // 使用传统方法作为备选
                fallbackCopyTextToClipboard(codeContent, btn, originalText);
            }
        }
        
        // 备选复制方法（兼容旧浏览器）
        function fallbackCopyTextToClipboard(text, btn, originalText) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.top = '0';
            textArea.style.left = '0';
            textArea.style.width = '2em';
            textArea.style.height = '2em';
            textArea.style.padding = '0';
            textArea.style.border = 'none';
            textArea.style.outline = 'none';
            textArea.style.boxShadow = 'none';
            textArea.style.background = 'transparent';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    if (btn) {
                        btn.textContent = '✓ 已复制';
                        btn.style.background = '#28a745';
                        setTimeout(() => {
                            btn.textContent = originalText;
                            btn.style.background = '#007acc';
                        }, 2000);
                    }
                } else {
                    throw new Error('execCommand failed');
                }
            } catch (err) {
                console.error('复制失败:', err);
                // 最后尝试：直接选中代码让用户手动复制
                const codeEl = document.getElementById('codeContent');
                if (codeEl) {
                    const range = document.createRange();
                    range.selectNode(codeEl);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    alert('自动复制失败，代码已选中，请按 Ctrl+C (Windows) 或 Cmd+C (Mac) 手动复制');
                } else {
                    alert('复制失败，请手动复制代码');
                }
            } finally {
                document.body.removeChild(textArea);
            }
        }

        // 页面加载时初始化代码显示
        document.addEventListener('DOMContentLoaded', function() {
            updateCodeDisplay();
        });

        // 获取导出下载 URL（拼接域名）
        function getExportDownloadUrl(url) {
            if (!url) return url;
            // 如果是完整 URL（包含 http:// 或 https://），直接返回
            if (url.startsWith('http://') || url.startsWith('https://')) {
                return url;
            }
            // 如果是相对路径，拼接配置的域名
            if (url.startsWith('/upload')) {
                return config.exportDownloadDomain + url.substring('/upload'.length);
            }
            // 如果是以 / 开头的其他路径，拼接当前域名
            if (url.startsWith('/')) {
                return window.location.origin + url;
            }
            // 其他情况，拼接配置的域名
            return config.exportDownloadDomain + '/' + url;
        }


        // 当前导出的业务ID
        let currentExportBusinessId = 'demoXlsWriterExport';

        // 打开导出弹窗
        function openExportModal(businessId = 'demoXlsWriterExport') {
            currentExportBusinessId = businessId;
            const modal = document.getElementById('exportModal');
            modal.classList.add('active');
            
            // 更新弹窗标题
            const modalTitle = modal.querySelector('.modal-title');
            if (modalTitle) {
                const titles = {
                    'demoXlsWriterExport': '导出数据（XlsWriter驱动）',
                    'demoSpreadSheetExport': '导出数据（SpreadSheet驱动）'
                };
                modalTitle.textContent = titles[businessId] || '导出数据';
            }
            
            // 确保弹窗内容可见
            const modalBody = modal.querySelector('.modal-body');
            if (modalBody) {
                modalBody.style.display = 'flex';
                modalBody.style.visibility = 'visible';
            }
            
            // 立即初始化进度显示，确保用户能看到
            // 使用 requestAnimationFrame 确保DOM已完全渲染
            requestAnimationFrame(() => {
                updateExportProgress(0, '准备中...');
                updateExportProgressInfo({
                    total: 0,
                    progress: 0,
                    success: 0,
                    fail: 0,
                    status: '待处理',
                    statusClass: 'status-1',
                    percent: 0
                });
                
                // 再延迟一下再开始导出，确保样式已应用
                setTimeout(() => {
                    startExport();
                }, 50);
            });
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.remove('active');
            if (exportProgressInterval) {
                clearInterval(exportProgressInterval);
                exportProgressInterval = null;
            }
            if (exportMessageInterval) {
                clearInterval(exportMessageInterval);
                exportMessageInterval = null;
            }
            resetExportProgress();
        }

        // 开始导出
        async function startExport() {
            try {
                updateExportProgress(0, '正在创建导出任务...');
                addExportMessage('开始导出...', '');
                
                const response = await fetch(`${API_BASE}/export`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        businessId: currentExportBusinessId,
                        param: {}
                    })
                });
                const result = await response.json();
                if (result.code === 0) {
                    exportToken = result.data.token;
                    addExportMessage('导出任务已创建', 'success');
                    
                    // 初始化进度信息显示
                    updateExportProgressInfo({
                        total: 0,
                        progress: 0,
                        success: 0,
                        fail: 0,
                        status: '待处理',
                        statusClass: 'status-1',
                        percent: 0
                    });
                    
                    if (result.data.response) {
                        // 同步导出完成，但仍需要查询一次进度信息以显示完整数据
                        updateExportProgress(95, '导出完成中...');
                        // 立即查询一次进度，然后启动轮询以确保获取到最终状态
                        pollExportProgress();
                        startExportProgressPolling();
                        // 保存下载地址并显示下载按钮
                        exportDownloadUrl = getExportDownloadUrl(result.data.response);
                        // 延迟显示下载按钮，等待进度查询完成
                        setTimeout(() => {
                            showExportDownloadButton();
                        }, 500);
                    } else {
                        // 异步导出，开始轮询进度
                        updateExportProgress(5, '任务已提交，等待处理...');
                        startExportProgressPolling();
                    }
                } else {
                    addExportMessage('导出失败: ' + result.msg, 'error');
                    updateExportProgress(0, '导出失败');
                }
            } catch (error) {
                console.error('导出失败:', error);
                addExportMessage('导出失败: ' + error.message, 'error');
                updateExportProgress(0, '导出失败');
            }
        }

        // 启动导出进度和消息轮询
        function startExportProgressPolling() {
            // 启动进度轮询
            if (exportProgressInterval) {
                clearInterval(exportProgressInterval);
            }
            pollExportProgress();
            exportProgressInterval = setInterval(pollExportProgress, 1000);
            
            // 启动消息轮询
            if (exportMessageInterval) {
                clearInterval(exportMessageInterval);
            }
            pollExportMessage();
            exportMessageInterval = setInterval(pollExportMessage, 1000);
        }

        // 轮询导出进度（只查询进度接口）
        async function pollExportProgress() {
            if (!exportToken) {
                clearInterval(exportProgressInterval);
                exportProgressInterval = null;
                return;
            }
            
            try {
                // 查询进度接口
                const response = await fetch(`${API_BASE}/progress?token=${exportToken}`);
                const result = await response.json();
                
                if (result.code === 0) {
                    // 确保正确获取进度数据，支持多种可能的数据结构
                    const progress = result.data?.progress || {};
                    const total = Number(progress.total) || 0;
                    const progressCount = Number(progress.progress) || 0;
                    const success = Number(progress.success) || 0;
                    const fail = Number(progress.fail) || 0;
                    const status = Number(progress.status) || 1;
                    
                    // 调试：打印API返回的完整数据（仅在开发时使用）
                    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                        console.log('导出进度API返回:', result);
                        console.log('解析后的进度数据:', { total, progressCount, success, fail, status });
                    }
                    
                    // 计算百分比
                    let percent = 0;
                    if (total > 0) {
                        percent = Math.round((progressCount / total) * 100);
                    } else if (status === 2 || status === 5) {
                        // 处理中或正在输出时，即使没有总数也显示一个估算进度
                        percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 10;
                    } else if (status === 1) {
                        percent = 5;
                    }
                    
                    // 状态映射：1待处理、2处理中、3输出上传中、4处理失败、5输出上传中、6完成
                    const statusMap = {
                        1: { text: '待处理', class: 'status-1' },
                        2: { text: '处理中', class: 'status-2' },
                        3: { text: '输出上传中', class: 'status-3' },
                        4: { text: '处理失败', class: 'status-4' },
                        5: { text: '输出上传中', class: 'status-5' },
                        6: { text: '完成', class: 'status-6' }
                    };
                    const statusInfo = statusMap[status] || { text: '未知', class: '' };
                    
                    // 更新进度信息显示（确保每次都更新，即使值为0）
                    updateExportProgressInfo({
                        total,
                        progress: progressCount,
                        success,
                        fail,
                        status: statusInfo.text,
                        statusClass: statusInfo.class,
                        percent
                    });
                    
                    // 更新进度条
                    updateExportProgress(percent, `${statusInfo.text}${total > 0 ? ' (' + percent + '%)' : ''}`);
                    
                    // 根据状态终止进度轮询（状态4或6）
                    if (status === 4 || status === 6) {
                        clearInterval(exportProgressInterval);
                        exportProgressInterval = null;
                        
                        if (status === 6) {
                            // 完成状态，从 result.data.data.response 获取文件地址
                            const fileResponse = result.data?.data?.response || '';
                            if (fileResponse) {
                                addExportMessage('导出成功！', 'success');
                                exportDownloadUrl = getExportDownloadUrl(fileResponse);
                                showExportDownloadButton();
                            } else {
                                addExportMessage('导出完成，但未获取到文件地址', 'error');
                            }
                        } else if (status === 4) {
                            // 处理失败
                            addExportMessage('导出失败', 'error');
                            updateExportProgress(0, '导出失败');
                        }
                    }
                } else {
                    addExportMessage('获取进度失败: ' + result.msg, 'error');
                }
            } catch (error) {
                console.error('获取进度失败:', error);
                addExportMessage('获取进度失败: ' + error.message, 'error');
            }
        }

        // 轮询导出消息（只查询消息接口）
        async function pollExportMessage() {
            if (!exportToken) {
                clearInterval(exportMessageInterval);
                exportMessageInterval = null;
                return;
            }
            
            try {
                const messageResponse = await fetch(`${API_BASE}/message?token=${exportToken}`);
                const messageResult = await messageResponse.json();
                if (messageResult.code === 0) {
                    const messages = messageResult.data.message || [];
                    if (messages.length > 0) {
                        messages.forEach(msg => {
                            addExportMessage(msg, msg.includes('失败') || msg.includes('错误') ? 'error' : '');
                        });
                    }
                    // 根据 isEnd 终止消息轮询
                    if (messageResult.data.isEnd === true) {
                        clearInterval(exportMessageInterval);
                        exportMessageInterval = null;
                    }
                }
            } catch (e) {
                console.warn('获取消息失败:', e);
            }
        }

        // 更新导出进度信息
        function updateExportProgressInfo(info) {
            const progressInfoEl = document.getElementById('exportProgressInfo');
            if (!progressInfoEl) {
                console.warn('导出进度信息容器不存在');
                return;
            }
            
            // 强制显示进度信息容器
            progressInfoEl.style.display = 'grid';
            progressInfoEl.style.visibility = 'visible';
            progressInfoEl.style.opacity = '1';
            
            // 确保所有值都是数字类型，并正确显示
            const totalEl = document.getElementById('exportTotal');
            const progressEl = document.getElementById('exportProgress');
            const successEl = document.getElementById('exportSuccess');
            const failEl = document.getElementById('exportFail');
            const statusEl = document.getElementById('exportStatus');
            
            // 强制更新所有元素，确保显示
            if (totalEl) {
                totalEl.textContent = String(info.total ?? 0);
                totalEl.style.display = 'block';
                totalEl.style.visibility = 'visible';
                totalEl.style.opacity = '1';
            }
            
            if (progressEl) {
                progressEl.textContent = String(info.progress ?? 0);
                progressEl.style.display = 'block';
                progressEl.style.visibility = 'visible';
                progressEl.style.opacity = '1';
            }
            
            if (successEl) {
                successEl.textContent = String(info.success ?? 0);
                successEl.style.display = 'block';
                successEl.style.visibility = 'visible';
                successEl.style.opacity = '1';
            }
            
            if (failEl) {
                failEl.textContent = String(info.fail ?? 0);
                failEl.style.display = 'block';
                failEl.style.visibility = 'visible';
                failEl.style.opacity = '1';
            }
            
            if (statusEl) {
                statusEl.textContent = info.status || '待处理';
                statusEl.className = 'progress-info-value status ' + (info.statusClass || 'status-1');
                statusEl.style.display = 'block';
                statusEl.style.visibility = 'visible';
                statusEl.style.opacity = '1';
            }
            
            // 确保所有进度信息项都可见
            const progressItems = progressInfoEl.querySelectorAll('.progress-info-item');
            progressItems.forEach(item => {
                item.style.display = 'flex';
                item.style.visibility = 'visible';
                item.style.opacity = '1';
            });
        }

        // 更新导出进度条
        function updateExportProgress(percent, text) {
            const progressFillEl = document.getElementById('exportProgressFill');
            const progressTextEl = document.getElementById('exportProgressText');
            const progressBarEl = document.getElementById('exportProgressFill')?.parentElement;
            
            if (!progressFillEl || !progressTextEl) {
                console.warn('进度条元素不存在', { progressFillEl, progressTextEl });
                return;
            }
            
            if (progressBarEl) {
                progressBarEl.style.display = 'block';
                progressBarEl.style.visibility = 'visible';
            }
            
            // 确保百分比在0-100之间
            const safePercent = Math.max(0, Math.min(100, percent));
            progressFillEl.style.width = safePercent + '%';
            progressFillEl.style.display = 'block';
            progressFillEl.style.visibility = 'visible';
            progressFillEl.style.opacity = '1';
            
            // 更新文本，转换为小写
            const displayText = (text || '准备中...').toLowerCase();
            progressTextEl.textContent = displayText;
            progressTextEl.style.display = 'block';
            progressTextEl.style.visibility = 'visible';
        }

        function resetExportProgress() {
            updateExportProgress(0, '准备中...');
            // 重置进度信息为初始值，使用统一的更新函数
            updateExportProgressInfo({
                total: 0,
                progress: 0,
                success: 0,
                fail: 0,
                status: '待处理',
                statusClass: 'status-1',
                percent: 0
            });
            
            const messagesEl = document.getElementById('exportMessages');
            if (messagesEl) messagesEl.innerHTML = '';
            
            const downloadArea = document.getElementById('exportDownloadArea');
            if (downloadArea) downloadArea.style.visibility = 'hidden';
            
            exportToken = null;
            exportDownloadUrl = null;
        }

        // 显示下载按钮
        function showExportDownloadButton() {
            const downloadArea = document.getElementById('exportDownloadArea');
            if (downloadArea && exportDownloadUrl) {
                downloadArea.style.visibility = 'visible';
            }
        }

        // 下载导出文件（在当前页面打开）
        function downloadExportFile() {
            if (exportDownloadUrl) {
                // 在当前页面打开下载地址
                window.location.href = exportDownloadUrl;
            } else {
                alert('下载地址不存在');
            }
        }

        function addExportMessage(message, type = '') {
            const container = document.getElementById('exportMessages');
            const item = document.createElement('div');
            item.className = 'message-item ' + type;
            item.textContent = message;
            container.appendChild(item);
            container.scrollTop = container.scrollHeight;
        }

        // 打开导入弹窗
        function openImportModal() {
            document.getElementById('importModal').classList.add('active');
            resetImportProgress();
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.remove('active');
            if (importProgressInterval) {
                clearInterval(importProgressInterval);
                importProgressInterval = null;
            }
            if (importMessageInterval) {
                clearInterval(importMessageInterval);
                importMessageInterval = null;
            }
            resetImportProgress();
            document.getElementById('importFile').value = '';
        }

        function handleFileSelect(input) {
            const fileNameEl = document.getElementById('importFileName');
            if (input.files && input.files[0]) {
                fileNameEl.textContent = '已选择: ' + input.files[0].name;
            } else {
                fileNameEl.textContent = '';
            }
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            const wrapper = document.getElementById('fileInputWrapper');
            wrapper.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            const wrapper = document.getElementById('fileInputWrapper');
            wrapper.classList.remove('drag-over');
        }

        function handleFileDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            const wrapper = document.getElementById('fileInputWrapper');
            wrapper.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files && files.length > 0) {
                const file = files[0];
                // 检查文件类型
                const validTypes = ['.xlsx', '.xls'];
                const fileName = file.name.toLowerCase();
                const isValid = validTypes.some(type => fileName.endsWith(type));
                
                if (isValid) {
                    const fileInput = document.getElementById('importFile');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                    handleFileSelect(fileInput);
                } else {
                    alert('请选择 .xlsx 或 .xls 格式的文件');
                }
            }
        }

        // 下载模板
        async function downloadTemplate() {
            try {
                const infoResponse = await fetch(`${API_BASE}/info?businessId=demoImport`);
                const infoResult = await infoResponse.json();
                if (infoResult.code === 0 && infoResult.data.templateBusinessId) {
                    const templateBusinessId = infoResult.data.templateBusinessId;
                    const response = await fetch(`${API_BASE}/export`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            businessId: templateBusinessId,
                            param: {}
                        })
                    });
                    const result = await response.json();
                    if (result.code === 0 && result.data.response) {
                        window.open(getExportDownloadUrl(result.data.response), '_blank');
                    } else {
                        alert('下载模板失败: ' + (result.msg || '未知错误'));
                    }
                } else {
                    alert('获取模板信息失败');
                }
            } catch (error) {
                console.error('下载模板失败:', error);
                alert('下载模板失败: ' + error.message);
            }
        }

        // 开始导入
        async function startImport() {
            const fileInput = document.getElementById('importFile');
            const file = fileInput.files[0];
            if (!file) {
                alert('请先选择文件');
                return;
            }

            // 上传文件
            const formData = new FormData();
            formData.append('file', file);
            
            try {
                updateImportProgress(10, '上传文件中...');
                addImportMessage('开始上传文件...', '');
                
                // 先上传文件获取URL
                const uploadResponse = await fetch('/demo/upload', {
                    method: 'POST',
                    body: formData
                });
                const uploadResult = await uploadResponse.json();
                
                if (uploadResult.code !== 0) {
                    throw new Error(uploadResult.msg || '文件上传失败');
                }
                
                // 获取文件路径，拼接完整地址
                const filePath = uploadResult.data.filePath;
                const fileUrl = config.uploadDomain + '/' + filePath.replace(/^\/+/, '');
                
                addImportMessage('文件上传成功', 'success');
                updateImportProgress(30, '开始导入...');
                
                // 调用导入接口
                const response = await fetch(`${API_BASE}/import`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        businessId: 'demoImport',
                        url: fileUrl
                    })
                });
                const result = await response.json();
                
                if (result.code === 0) {
                    importToken = result.data.token;
                    addImportMessage('导入任务已创建', 'success');
                    // 初始化进度信息显示（导入初始没有总数）
                    updateImportProgressInfo({
                        total: 0,
                        progress: 0,
                        success: 0,
                        fail: 0,
                        status: '待处理',
                        statusClass: 'status-1',
                        percent: 0
                    });
                    startImportProgressPolling();
                } else {
                    throw new Error(result.msg || '导入失败');
                }
            } catch (error) {
                console.error('导入失败:', error);
                addImportMessage('导入失败: ' + error.message, 'error');
                updateImportProgress(0, '导入失败');
            }
        }

        // 启动导入进度和消息轮询
        function startImportProgressPolling() {
            // 启动进度轮询
            if (importProgressInterval) {
                clearInterval(importProgressInterval);
            }
            pollImportProgress();
            importProgressInterval = setInterval(pollImportProgress, 1000);
            
            // 启动消息轮询
            if (importMessageInterval) {
                clearInterval(importMessageInterval);
            }
            pollImportMessage();
            importMessageInterval = setInterval(pollImportMessage, 1000);
        }

        // 轮询导入进度（只查询进度接口）
        async function pollImportProgress() {
            if (!importToken) {
                clearInterval(importProgressInterval);
                importProgressInterval = null;
                return;
            }
            
            try {
                // 查询进度接口
                const response = await fetch(`${API_BASE}/progress?token=${importToken}`);
                const result = await response.json();
                
                if (result.code === 0) {
                    const progress = result.data.progress || {};
                    const total = progress.total || 0;
                    const progressCount = progress.progress || 0;
                    const success = progress.success || 0;
                    const fail = progress.fail || 0;
                    const status = progress.status || 1;
                    
                    // 计算百分比：导入初始没有总数，所以只有当总数大于0时才计算百分比
                    let percent = 0;
                    if (total > 0) {
                        // 有总数时，根据进度数和总数计算百分比
                        percent = Math.round((progressCount / total) * 100);
                    } else {
                        // 如果没有总数，根据状态显示进度
                        // 状态2（处理中）或5（正在输出）时显示一个估算进度
                        if (status === 2 || status === 5) {
                            // 处理中时，根据已处理的进度数显示一个估算值（不超过99%）
                            percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 10;
                        } else if (status === 1) {
                            // 待处理时显示5%
                            percent = 5;
                        } else {
                            // 其他状态保持当前进度或0
                            percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 0;
                        }
                    }
                    
                    // 状态映射：1待处理、2处理中、3处理完成、4处理失败、5正在输出、6完成
                    const statusMap = {
                        1: { text: '待处理', class: 'status-1' },
                        2: { text: '处理中', class: 'status-2' },
                        3: { text: '处理完成', class: 'status-3' },
                        4: { text: '处理失败', class: 'status-4' },
                        5: { text: '正在输出', class: 'status-5' },
                        6: { text: '完成', class: 'status-6' }
                    };
                    const statusInfo = statusMap[status] || { text: '未知', class: '' };
                    
                    // 更新进度信息显示
                    updateImportProgressInfo({
                        total,
                        progress: progressCount,
                        success,
                        fail,
                        status: statusInfo.text,
                        statusClass: statusInfo.class,
                        percent
                    });
                    
                    // 更新进度条
                    updateImportProgress(percent, `${statusInfo.text} (${total > 0 ? percent + '%' : '处理中...'})`);
                    
                    // 根据状态终止进度轮询（状态4或6）
                    if (status === 4 || status === 6) {
                        clearInterval(importProgressInterval);
                        importProgressInterval = null;
                        
                        if (status === 6) {
                            // 完成状态
                            addImportMessage('导入完成！', 'success');
                        } else if (status === 4) {
                            // 处理失败
                            addImportMessage('导入失败', 'error');
                            updateImportProgress(0, '导入失败');
                        }
                    }
                } else {
                    addImportMessage('获取进度失败: ' + result.msg, 'error');
                }
            } catch (error) {
                console.error('获取进度失败:', error);
                addImportMessage('获取进度失败: ' + error.message, 'error');
            }
        }

        // 轮询导入消息（只查询消息接口）
        async function pollImportMessage() {
            if (!importToken) {
                clearInterval(importMessageInterval);
                importMessageInterval = null;
                return;
            }
            
            try {
                const messageResponse = await fetch(`${API_BASE}/message?token=${importToken}`);
                const messageResult = await messageResponse.json();
                if (messageResult.code === 0) {
                    const messages = messageResult.data.message || [];
                    if (messages.length > 0) {
                        messages.forEach(msg => {
                            addImportMessage(msg, msg.includes('失败') || msg.includes('错误') ? 'error' : '');
                        });
                    }
                    // 根据 isEnd 终止消息轮询
                    if (messageResult.data.isEnd === true) {
                        clearInterval(importMessageInterval);
                        importMessageInterval = null;
                    }
                }
            } catch (e) {
                console.warn('获取消息失败:', e);
            }
        }

        // 更新导入进度信息
        function updateImportProgressInfo(info) {
            const progressInfoEl = document.getElementById('importProgressInfo');
            if (progressInfoEl) {
                // 总数：如果没有总数则显示 "0"
                document.getElementById('importTotal').textContent = info.total > 0 ? info.total : '0';
                document.getElementById('importProgress').textContent = info.progress || 0;
                document.getElementById('importSuccess').textContent = info.success || 0;
                document.getElementById('importFail').textContent = info.fail || 0;
                const statusEl = document.getElementById('importStatus');
                statusEl.textContent = info.status || '待处理';
                statusEl.className = 'progress-info-value status ' + (info.statusClass || 'status-1');
            }
        }

        // 更新导入进度条
        function updateImportProgress(percent, text) {
            const progressFillEl = document.getElementById('importProgressFill');
            const progressTextEl = document.getElementById('importProgressText');
            
            if (!progressFillEl || !progressTextEl) {
                return;
            }
            
            const safePercent = Math.max(0, Math.min(100, percent));
            progressFillEl.style.width = safePercent + '%';
            
            // 更新文本，转换为小写
            const displayText = (text || '等待上传...').toLowerCase();
            progressTextEl.textContent = displayText;
        }

        function resetImportProgress() {
            updateImportProgress(0, '等待上传...');
            // 重置进度信息为初始值
            document.getElementById('importTotal').textContent = '0';
            document.getElementById('importProgress').textContent = '0';
            document.getElementById('importSuccess').textContent = '0';
            document.getElementById('importFail').textContent = '0';
            document.getElementById('importStatus').textContent = '待处理';
            document.getElementById('importStatus').className = 'progress-info-value status status-1';
            document.getElementById('importMessages').innerHTML = '';
            document.getElementById('importFileName').textContent = '';
            importToken = null;
        }

        function addImportMessage(message, type = '') {
            const container = document.getElementById('importMessages');
            const item = document.createElement('div');
            item.className = 'message-item ' + type;
            item.textContent = message;
            container.appendChild(item);
            container.scrollTop = container.scrollHeight;
        }

    </script>
</body>
</html>

