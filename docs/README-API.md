# API 文档

## 导入 Apifox

1. 打开 Apifox
2. 新建项目或选择已有项目
3. 点击「导入」→「导入数据」→「OpenAPI/Swagger」
4. 选择 `apifox-openapi.json` 文件导入

## 接口概览

| 分组 | 接口 | 方法 | 说明 |
|------|------|------|------|
| Excel | /excel/export | GET/POST | 导出数据 |
| Excel | /excel/import | POST | 导入数据 |
| Excel | /excel/progress | GET | 查询进度 |
| Excel | /excel/message | GET | 查询消息 |
| Excel | /excel/info | GET | 获取业务信息 |
| Demo | /demo/index | GET | Demo 首页 |
| Demo | /demo/list | GET | 数据列表 |
| Demo | /demo/upload | POST | 文件上传 |

## 业务 ID 说明

- **导出**：demoExport（同步）、demoAsyncExport（异步）、demoImportTemplate（导入模板）
- **导入**：demoImport
