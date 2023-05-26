<div align="center">
  <h1 align="center">GPTLink</h1>
  <p> 只需简单几步，即可快速搭建可商用的 ChatGPT 站点。</p>

  [体验地址](https://gpt-link.com/?shareOpenId=mjOfmdjyCBEku7fY) · [演示图片](./docs/show/README.md) · [反馈](https://github.com/gptlink/gptlink/issues) · [微信加群](./docs/images/qrcode.png)

  [商务合作](./docs/images/qrcode.png) · [关注公众号](./docs/images/offical.jpg) · [打赏开发者](./docs/images/payment.jpeg)

  <img src="https://github.com/gptlink/gptlink/assets/1472352/98a5012b-3111-4c50-bd36-c8eabf17f6e7" />
 
</div>

## 功能概览

- 支持 Docker 部署
- 开箱即用的控制台
- 完美适配移动端
- 自定义付费套餐
- 一键导出对话
- 任务拉新获客

## 开始使用

1. 项目基于 PHP (Hyperf) + Vue 开发，推荐使用 Docker 进行部署；
2. 准备好一个 API Key，推荐使用 [GPTLINK](https://gpt-link.com) Key；
   - [GPTLINK](https://gpt-link.com) Key ，注册完成之后进入个人中心申请开发者后获取 API Key，过程非常简单，无需审核，接口无需代理；
   - OpenAi 官方 Key；
3. 微信相关资源（[网站应用](https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Wechat_Login.html)，[微信公众号](https://mp.weixin.qq.com/)，[微信支付](https://pay.weixin.qq.com/)），网站应用用于 PC 端扫码登录，公众号用于微信内网页登录，缺省情况将无法在对应渠道使用；

## 项目配置

项目提供有限的权限控制功能，项目配置文件位于 `gptserver/.env`，如诺不存在此文件，将 `gptserver/.env.example` 更名为 `.env` 作为配置项进行使用，详细的配置说明 [点此查看](./docs/ENV.md)

## 部署
项目支持多种部署方式，部署文档参考：[点此查看](./docs/DEPLOY.md)

- PHP 环境部署
- Docker 部署
- Docker Compose 部署
- 云主机镜像部署

### 访问

部署完成后访问 `http://域名或IP` 进入对话页面，`/admin` 路径访问管理页，管理员账号密码为配置项设置的 `ADMIN_USERNAME` 与 `ADMIN_USERNAME` ，如不传入，默认账号密码为 `admin` `admin888`

## 版本计划

- [ ] 兑换码
- [ ] AI 生图
- [ ] 分销
- [ ] 对话记录
- [ ] 统计视图

## 参与贡献

我们深知这不是一个完美的产品，但是它只是一个开始，欢迎加入我们一起完善！:heart: 请参阅 [贡献指南](./CONTRIBUTING.md)

<a href="https://github.com/gptlink/gptlink/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=gptlink/gptlink" />
</a>

## 特别鸣谢

- [@overtrue](https://github.com/overtrue) 
- [@Lainy0307](https://github.com/Lainy0307)

## 疑难解答

常见问题汇总：[点击查看](./docs/FAQ.md)

## 开源协议
Apache License Version 2.0 see http://www.apache.org/licenses/LICENSE-2.0.html
