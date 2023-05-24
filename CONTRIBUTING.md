# 贡献指南
感谢你的宝贵时间。你的贡献将使这个项目变得更好！在提交贡献之前，请务必花点时间阅读下面的入门指南。

## 语义化版本
该项目遵循语义化版本。我们对重要的漏洞修复发布修订号，对新特性或不重要的变更发布次版本号，对重大且不兼容的变更发布主版本号。

每个重大更改都将记录在 `changelog` 中。

## 提交 Pull Request
1. Fork [此仓库](https://github.com/gptlink/gptlink)，从 `master` 创建分支。新功能实现请发 pull request 到 `feature` 分支。其他更改发到 `master` 分支。
2. php框架基于Hyperf开发，项目目录为gptserver
3. 建议的开发环境镜像为`hyperf/hyperf:8.0-alpine-v3.11-swoole`
5. `gptserver` 目录下执行 `composer install`。
6. 对代码库进行更改。如果适用的话，请确保进行了相应的测试。
7. 请在`gptserver`目录下执行 `composer fix` 进行代码格式检查。
9. 提交 git commit, 请同时遵守 [Commit 规范](#commit-指南)

## Commit 指南

Commit messages 请遵循[conventional-changelog 标准](https://www.conventionalcommits.org/en/v1.0.0/)：

```bash
<类型>[可选 范围]: <描述>

[可选 正文]

[可选 脚注]
```

### Commit 类型

以下是 commit 类型列表:

- feat: 新特性或功能
- fix: 缺陷修复
- docs: 文档更新
- style: 代码风格或者组件样式更新
- refactor: 代码重构，不引入新功能和缺陷修复
- perf: 性能优化
- test: 单元测试
- chore: 其他不修改 src 或测试文件的提交


## License
MIT
