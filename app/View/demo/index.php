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

        /* Toast 提示 */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast {
            pointer-events: auto;
            min-width: 300px;
            max-width: 480px;
            padding: 14px 20px;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: toastIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            word-break: break-word;
        }

        .toast.removing {
            animation: toastOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .toast-error {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        }

        .toast-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .toast-warn {
            background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            color: #333;
        }

        .toast-icon {
            font-size: 18px;
            flex-shrink: 0;
            line-height: 1.2;
        }

        .toast-body {
            flex: 1;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.7;
            flex-shrink: 0;
            padding: 0;
            line-height: 1;
        }

        .toast-close:hover {
            opacity: 1;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(40px); }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Excel 导入导出 Demo</h1>
        
        <div class="toolbar">
            <button class="btn btn-primary" onclick="openExportModal()">导出数据</button>
            <button class="btn btn-success" onclick="openImportModal()">导入数据</button>
        </div>

        <table id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>邮箱</th>
                    <th>创建时间</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (!empty($dataList)): ?>
                    <?php foreach ($dataList as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['id']) ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['email']) ?></td>
                            <td><?= htmlspecialchars($item['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                            暂无数据
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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

    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Toast 提示工具
        function showToast(message, type = 'error', duration = 4000) {
            const container = document.getElementById('toastContainer');
            const icons = { error: '❌', success: '✅', warn: '⚠️' };
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <span class="toast-icon">${icons[type] || icons.error}</span>
                <span class="toast-body">${message}</span>
                <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('removing');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        /**
         * 统一请求封装：自动处理网络错误 + 业务错误码弹窗
         * 返回 { ok: boolean, data: any, raw: object }
         */
        async function apiRequest(url, options = {}) {
            let response;
            try {
                response = await fetch(url, options);
            } catch (e) {
                showToast('网络请求失败: ' + e.message, 'error');
                throw e;
            }

            if (!response.ok) {
                const text = await response.text().catch(() => '');
                showToast(`请求失败 [HTTP ${response.status}]: ${text || response.statusText}`, 'error');
                throw new Error(`HTTP ${response.status}`);
            }

            let result;
            try {
                result = await response.json();
            } catch (e) {
                showToast('响应解析失败，返回内容不是有效 JSON', 'error');
                throw e;
            }

            if (result.code !== 0) {
                showToast(result.message || result.msg || '请求失败 (code: ' + result.code + ')', 'error');
                return { ok: false, data: result.data, raw: result };
            }

            return { ok: true, data: result.data, raw: result };
        }

        // 配置信息
        const config = {
            exportDownloadDomain: window.location.origin + '/upload',
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

        // 加载数据列表
        async function loadData() {
            try {
                const { ok, data } = await apiRequest('/demo/list');
                if (ok && data.list) {
                    renderTable(data.list);
                }
            } catch (error) {
                // apiRequest 已弹窗
            }
        }

        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 40px; color: #999;">暂无数据</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(item => `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.email}</td>
                    <td>${item.created_at}</td>
                </tr>
            `).join('');
        }

        // 打开导出弹窗
        function openExportModal() {
            const modal = document.getElementById('exportModal');
            modal.classList.add('active');
            
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

                const { ok, data, raw } = await apiRequest(`${API_BASE}/export`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ business_id: 'demoAsyncExport', param: {} })
                });

                if (!ok) {
                    addExportMessage('导出失败: ' + (raw.message || '未知错误'), 'error');
                    updateExportProgress(0, '导出失败');
                    return;
                }

                exportToken = data.token;
                addExportMessage('导出任务已创建', 'success');

                if (data.response) {
                    updateExportProgress(100, '导出完成');
                    addExportMessage('导出成功！', 'success');
                    exportDownloadUrl = getExportDownloadUrl(data.response);
                    showExportDownloadButton();
                } else {
                    updateExportProgress(5, '任务已提交，等待处理...');
                    updateExportProgressInfo({
                        total: 0, progress: 0, success: 0, fail: 0,
                        status: '待处理', statusClass: 'status-1', percent: 0
                    });
                    startExportProgressPolling();
                }
            } catch (error) {
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
                const { ok, data, raw } = await apiRequest(`${API_BASE}/progress?token=${exportToken}`);
                if (!ok) return;

                const progress = data?.progress || {};
                const total = Number(progress.total) || 0;
                const progressCount = Number(progress.progress) || 0;
                const success = Number(progress.success) || 0;
                const fail = Number(progress.fail) || 0;
                const status = Number(progress.status) || 1;

                let percent = 0;
                if (total > 0) {
                    percent = Math.round((progressCount / total) * 100);
                } else if (status === 2 || status === 5) {
                    percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 10;
                } else if (status === 1) {
                    percent = 5;
                }

                const statusMap = {
                    1: { text: '待处理', class: 'status-1' },
                    2: { text: '处理中', class: 'status-2' },
                    3: { text: '处理完成', class: 'status-3' },
                    4: { text: '处理失败', class: 'status-4' },
                    5: { text: '正在输出', class: 'status-5' },
                    6: { text: '完成', class: 'status-6' }
                };
                const statusInfo = statusMap[status] || { text: '未知', class: '' };

                updateExportProgressInfo({
                    total, progress: progressCount, success, fail,
                    status: statusInfo.text, statusClass: statusInfo.class, percent
                });
                updateExportProgress(percent, `${statusInfo.text}${total > 0 ? ' (' + percent + '%)' : ''}`);

                if (status === 4 || status === 6) {
                    clearInterval(exportProgressInterval);
                    exportProgressInterval = null;

                    if (status === 6) {
                        const fileResponse = data?.data?.response || '';
                        if (fileResponse) {
                            addExportMessage('导出成功！', 'success');
                            exportDownloadUrl = getExportDownloadUrl(fileResponse);
                            showExportDownloadButton();
                        } else {
                            showToast('导出完成，但未获取到文件地址', 'warn');
                        }
                    } else {
                        showToast('导出失败', 'error');
                        addExportMessage('导出失败', 'error');
                        updateExportProgress(0, '导出失败');
                    }
                }
            } catch (error) {
                // apiRequest 已弹窗，此处仅补充消息面板
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
                const { ok, data } = await apiRequest(`${API_BASE}/message?token=${exportToken}`);
                if (!ok) return;

                const messages = data.message || [];
                messages.forEach(msg => {
                    addExportMessage(msg, msg.includes('失败') || msg.includes('错误') ? 'error' : '');
                });
                if (data.isEnd === true) {
                    clearInterval(exportMessageInterval);
                    exportMessageInterval = null;
                }
            } catch (e) {
                // apiRequest 已弹窗
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
                window.location.href = exportDownloadUrl;
            } else {
                showToast('下载地址不存在', 'warn');
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
                    showToast('请选择 .xlsx 或 .xls 格式的文件', 'warn');
                }
            }
        }

        // 下载模板
        async function downloadTemplate() {
            try {
                const infoRes = await apiRequest(`${API_BASE}/info?business_id=demoImport`);
                if (!infoRes.ok) return;

                const templateUrl = infoRes.data.templateUrl;
                if (templateUrl) {
                    window.open(getExportDownloadUrl(templateUrl), '_blank');
                    return;
                }

                showToast('获取模板信息失败：未配置模板地址', 'warn');
            } catch (error) {
                // apiRequest 已弹窗
            }
        }

        // 开始导入
        async function startImport() {
            const fileInput = document.getElementById('importFile');
            const file = fileInput.files[0];
            if (!file) {
                showToast('请先选择文件', 'warn');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            try {
                updateImportProgress(10, '上传文件中...');
                addImportMessage('开始上传文件...', '');

                const uploadRes = await apiRequest('/demo/upload', { method: 'POST', body: formData });
                if (!uploadRes.ok) {
                    addImportMessage('文件上传失败', 'error');
                    updateImportProgress(0, '上传失败');
                    return;
                }

                const filePath = uploadRes.data.filePath;
                const fileUrl = config.uploadDomain + '/' + filePath.replace(/^\/+/, '');

                addImportMessage('文件上传成功', 'success');
                updateImportProgress(30, '开始导入...');

                const importRes = await apiRequest(`${API_BASE}/import`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ business_id: 'demoImport', url: fileUrl })
                });

                if (!importRes.ok) {
                    addImportMessage('导入失败: ' + (importRes.raw.message || '未知错误'), 'error');
                    updateImportProgress(0, '导入失败');
                    return;
                }

                importToken = importRes.data.token;
                addImportMessage('导入任务已创建', 'success');
                updateImportProgressInfo({
                    total: 0, progress: 0, success: 0, fail: 0,
                    status: '待处理', statusClass: 'status-1', percent: 0
                });
                startImportProgressPolling();
            } catch (error) {
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
                const { ok, data } = await apiRequest(`${API_BASE}/progress?token=${importToken}`);
                if (!ok) return;

                const progress = data?.progress || {};
                const total = Number(progress.total) || 0;
                const progressCount = Number(progress.progress) || 0;
                const success = Number(progress.success) || 0;
                const fail = Number(progress.fail) || 0;
                const status = Number(progress.status) || 1;

                let percent = 0;
                if (total > 0) {
                    percent = Math.round((progressCount / total) * 100);
                } else if (status === 2 || status === 5) {
                    percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 10;
                } else if (status === 1) {
                    percent = 5;
                } else {
                    percent = progressCount > 0 ? Math.min(Math.round(progressCount / 10), 99) : 0;
                }

                const statusMap = {
                    1: { text: '待处理', class: 'status-1' },
                    2: { text: '处理中', class: 'status-2' },
                    3: { text: '处理完成', class: 'status-3' },
                    4: { text: '处理失败', class: 'status-4' },
                    5: { text: '正在输出', class: 'status-5' },
                    6: { text: '完成', class: 'status-6' }
                };
                const statusInfo = statusMap[status] || { text: '未知', class: '' };

                updateImportProgressInfo({
                    total, progress: progressCount, success, fail,
                    status: statusInfo.text, statusClass: statusInfo.class, percent
                });
                updateImportProgress(percent, `${statusInfo.text} (${total > 0 ? percent + '%' : '处理中...'})`);

                if (status === 4 || status === 6) {
                    clearInterval(importProgressInterval);
                    importProgressInterval = null;

                    if (status === 6) {
                        showToast('导入完成！', 'success');
                        addImportMessage('导入完成！', 'success');
                        loadData();
                    } else {
                        showToast('导入失败', 'error');
                        addImportMessage('导入失败', 'error');
                        updateImportProgress(0, '导入失败');
                    }
                }
            } catch (error) {
                // apiRequest 已弹窗
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
                const { ok, data } = await apiRequest(`${API_BASE}/message?token=${importToken}`);
                if (!ok) return;

                const messages = data.message || [];
                messages.forEach(msg => {
                    addImportMessage(msg, msg.includes('失败') || msg.includes('错误') ? 'error' : '');
                });
                if (data.isEnd === true) {
                    clearInterval(importMessageInterval);
                    importMessageInterval = null;
                }
            } catch (e) {
                // apiRequest 已弹窗
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

