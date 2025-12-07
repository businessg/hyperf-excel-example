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
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 24px;
        }

        h1 {
            margin-bottom: 24px;
            color: #333;
            font-size: 24px;
        }

        .toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #1890ff;
            color: white;
        }

        .btn-primary:hover {
            background: #40a9ff;
        }

        .btn-success {
            background: #52c41a;
            color: white;
        }

        .btn-success:hover {
            background: #73d13d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e8e8e8;
        }

        th {
            background: #fafafa;
            font-weight: 600;
            color: #333;
        }

        tr:hover {
            background: #fafafa;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 0;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .modal-header {
            padding: 24px 24px 16px 24px;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0 24px;
            padding-right: 16px;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .modal-footer {
            flex-shrink: 0;
            padding: 16px 24px 24px 24px;
            border-top: 1px solid #e8e8e8;
            text-align: center;
            margin-top: 0;
            min-height: 60px;
            box-sizing: border-box;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
            padding-bottom: 16px;
            border-bottom: 1px solid #e8e8e8;
            flex-shrink: 0;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: #333;
        }

        .progress-container {
            margin: 0 0 16px 0;
            height: 40px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #f0f0f0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: #1890ff;
            transition: width 0.3s;
            width: 0%;
        }

        .progress-text {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .progress-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 8px;
            margin: 0 0 16px 0;
            padding: 8px;
            background: #fafafa;
            border-radius: 4px;
            min-height: 55px;
            flex-shrink: 0;
        }

        .progress-info-item {
            display: flex;
            flex-direction: column;
            height: 55px;
        }

        .progress-info-label {
            font-size: 12px;
            color: #999;
            margin-bottom: 4px;
        }

        .progress-info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .progress-info-value.status {
            font-size: 14px;
        }

        .status-1 { color: #999; }
        .status-2 { color: #1890ff; }
        .status-3 { color: #52c41a; }
        .status-4 { color: #ff4d4f; }
        .status-5 { color: #faad14; }
        .status-6 { color: #52c41a; }

        .message-container {
            margin: 0;
            height: 180px;
            overflow-y: auto;
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            padding: 12px;
            background: #fafafa;
            flex-shrink: 0;
        }

        .message-item {
            padding: 4px 0;
            font-size: 13px;
            color: #666;
        }

        .message-item.error {
            color: #ff4d4f;
        }

        .message-item.success {
            color: #52c41a;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-shrink: 0;
        }

        .download-template {
            flex: 1;
        }

        .start-import-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .download-template-link {
            color: #1890ff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .download-template-link:hover {
            color: #40a9ff;
            text-decoration: underline;
        }

        .download-template-link:active {
            color: #096dd9;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            border: 2px dashed #d9d9d9;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s;
            cursor: pointer;
            margin: 0 0 16px 0;
            flex-shrink: 0;
        }

        .file-input-wrapper:hover {
            border-color: #1890ff;
            background: #f0f7ff;
        }

        .file-input-wrapper.drag-over {
            border-color: #1890ff;
            background: #e6f7ff;
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
            font-size: 32px;
            color: #d9d9d9;
            margin-bottom: 8px;
            line-height: 1;
        }

        .file-input-wrapper:hover .file-input-icon,
        .file-input-wrapper.drag-over .file-input-icon {
            color: #1890ff;
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
            color: #1890ff;
            word-break: break-all;
            padding: 8px;
            background: #f0f7ff;
            border-radius: 4px;
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
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="exportProgressFill"></div>
                    </div>
                    <div class="progress-text" id="exportProgressText">准备中...</div>
                    <div class="progress-info" id="exportProgressInfo">
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
                <div class="action-buttons">
                    <div class="download-template">
                        <a href="javascript:void(0)" class="download-template-link" onclick="downloadTemplate()">下载模板</a>
                    </div>
                </div>
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="importProgressFill"></div>
                    </div>
                    <div class="progress-text" id="importProgressText">等待上传...</div>
                </div>
                <div class="progress-info" id="importProgressInfo">
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
                    <div class="start-import-btn">
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
                const response = await fetch('/demo/list');
                const result = await response.json();
                if (result.code === 0 && result.data.list) {
                    renderTable(result.data.list);
                }
            } catch (error) {
                console.error('加载数据失败:', error);
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
            document.getElementById('exportModal').classList.add('active');
            startExport();
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
                        businessId: 'demoAsyncExport',
                        param: {}
                    })
                });
                const result = await response.json();
                if (result.code === 0) {
                    exportToken = result.data.token;
                    addExportMessage('导出任务已创建', 'success');
                    
                    if (result.data.response) {
                        // 同步导出完成
                        updateExportProgress(100, '导出完成');
                        addExportMessage('导出成功！', 'success');
                        // 保存下载地址并显示下载按钮
                        exportDownloadUrl = getExportDownloadUrl(result.data.response);
                        showExportDownloadButton();
                    } else {
                        // 异步导出，开始轮询进度
                        updateExportProgress(5, '任务已提交，等待处理...');
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
                    const progress = result.data.progress || {};
                    const total = progress.total || 0;
                    const progressCount = progress.progress || 0;
                    const success = progress.success || 0;
                    const fail = progress.fail || 0;
                    const status = progress.status || 1;
                    
                    // 计算百分比
                    const percent = total > 0 ? Math.round((progressCount / total) * 100) : 0;
                    
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
                    updateExportProgress(percent, `${statusInfo.text} (${percent}%)`);
                    
                    // 根据状态终止进度轮询（状态4或6）
                    if (status === 4 || status === 6) {
                        clearInterval(exportProgressInterval);
                        exportProgressInterval = null;
                        
                        if (status === 6) {
                            // 完成状态，从 result.data.data.response 获取文件地址
                            const fileResponse = result.data.data?.response || '';
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
            if (progressInfoEl) {
                document.getElementById('exportTotal').textContent = info.total || 0;
                document.getElementById('exportProgress').textContent = info.progress || 0;
                document.getElementById('exportSuccess').textContent = info.success || 0;
                document.getElementById('exportFail').textContent = info.fail || 0;
                const statusEl = document.getElementById('exportStatus');
                statusEl.textContent = info.status || '待处理';
                statusEl.className = 'progress-info-value status ' + (info.statusClass || 'status-1');
            }
        }

        // 更新导出进度条
        function updateExportProgress(percent, text) {
            document.getElementById('exportProgressFill').style.width = percent + '%';
            document.getElementById('exportProgressText').textContent = text;
        }

        function resetExportProgress() {
            updateExportProgress(0, '准备中...');
            // 重置进度信息为初始值
            document.getElementById('exportTotal').textContent = '0';
            document.getElementById('exportProgress').textContent = '0';
            document.getElementById('exportSuccess').textContent = '0';
            document.getElementById('exportFail').textContent = '0';
            document.getElementById('exportStatus').textContent = '待处理';
            document.getElementById('exportStatus').className = 'progress-info-value status status-1';
            document.getElementById('exportMessages').innerHTML = '';
            document.getElementById('exportDownloadArea').style.visibility = 'hidden';
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
                            loadData();
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
            document.getElementById('importProgressFill').style.width = percent + '%';
            document.getElementById('importProgressText').textContent = text;
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

