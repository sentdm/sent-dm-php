# Changelog

## [0.30.0](https://github.com/sentdm/sent-dm-php/compare/v0.29.0...v0.30.0) (2026-09-06)


### Features

* **api:** sync OpenAPI spec from production ([cfa43e9](https://github.com/sentdm/sent-dm-php/commit/cfa43e91f287317040a9d4598f3b1012da2e8921))
* **api:** sync OpenAPI spec from production ([59b1fe7](https://github.com/sentdm/sent-dm-php/commit/59b1fe7ea7ba343c42c3dabe898dec5de933ec4f))

## [0.29.0](https://github.com/sentdm/sent-dm-php/compare/v0.28.0...v0.29.0) (2026-08-31)


### Features

* **api:** sync OpenAPI spec from production ([8d446f8](https://github.com/sentdm/sent-dm-php/commit/8d446f80af19b342a0e50ca5a0646186a5d300b6))
* **api:** sync OpenAPI spec from production ([1e7fe7f](https://github.com/sentdm/sent-dm-php/commit/1e7fe7f80487582c2552403a44137c7459daf323))


### Bug Fixes

* sync the package version in src/Client.php to 0.28.0 ([d6d6dbd](https://github.com/sentdm/sent-dm-php/commit/d6d6dbdc1007f870e5e1ca414ceaec2bca42d8d0))

## [0.28.0](https://github.com/sentdm/sent-dm-php/compare/v0.27.0...v0.28.0) (2026-08-17)


### Highlights

Webhook payloads are now typed. The events Sent POSTs to your endpoint — `MessageEvent`, `InboundMessageEvent` and `TemplateEvent`, each with its own payload type — are generated types you can deserialize into, instead of a shape you had to hand-write from the docs.

The webhook delivery log is typed too. `event_data` on `GET /v3/webhooks/{id}/events` returns the exact envelope that was delivered, and now describes itself as one of those three rather than an opaque object.

Also in this release:

- `csp_id` on the brand object is deprecated and will be removed in a later release. It identifies the Campaign Service Provider that registered the brand, which is Sent, so the value is the same for every account. There is no replacement. Your own TCR identifiers, `tcr_brand_id` and `universal_ein`, are unaffected.
- Corrected descriptions for blocked sends, which now name the cases that gate a send before any delivery attempt: insufficient balance, a template not approved for sending, and free-form content with no open conversation.
- `campaign.volume` documents what an omitted value does. Leave it out and the campaign registers as standard, the higher-fee tier, with no error.

### Features

* **api:** sync OpenAPI spec from production ([a5bbe0b](https://github.com/sentdm/sent-dm-php/commit/a5bbe0b823db9194243c8f624ae0824feb59efb6))
* **api:** sync OpenAPI spec from production ([ab7b7ba](https://github.com/sentdm/sent-dm-php/commit/ab7b7baf3955595a243d5cb3959881ccae975372))
* **api:** sync OpenAPI spec from production ([86aa717](https://github.com/sentdm/sent-dm-php/commit/86aa717a917f0c4b2b8a30a21549a646d1ef8cb5))
* **sdk:** expose the delivered webhook payloads as models ([6345cab](https://github.com/sentdm/sent-dm-php/commit/6345cabc48e25ad27db8354eff01bbe8a13be63c))


### Chores

* add eager seal-dispatch workflow ([05db1cf](https://github.com/sentdm/sent-dm-php/commit/05db1cf3915b58a8b5fc5f8d93ecb90431167a3c))

## [0.27.0](https://github.com/sentdm/sent-dm-php/compare/v0.26.0...v0.27.0) (2026-08-08)


### Features

* **api:** sync OpenAPI spec from production ([2690356](https://github.com/sentdm/sent-dm-php/commit/2690356a9ef0b326dc7de10a94f7f295d9be02a5))


### Chores

* mark GitHub Releases as stable releases (prerelease: false) ([0c14853](https://github.com/sentdm/sent-dm-php/commit/0c148538acdb6e2b5b131dd4a0acc6963a3c1271))

## [0.26.0](https://github.com/sentdm/sent-dm-php/compare/v0.25.0...v0.26.0) (2026-07-07)


### Features

* enable release-please releases and back-sync trigger ([8113245](https://github.com/sentdm/sent-dm-php/commit/81132458b85b3929c54fb6dde1f8824a3f72a552))
* initial stlc build ([f7e4971](https://github.com/sentdm/sent-dm-php/commit/f7e497191a92300db703fa1c99c2c4ff81e71a7e))


### Chores

* add promote, back-sync, and trunk-lock workflows ([e22575a](https://github.com/sentdm/sent-dm-php/commit/e22575ac49007f2d8a3ddea2f1a46013f8c80d98))
* add release back-sync trigger workflow ([7ebd77c](https://github.com/sentdm/sent-dm-php/commit/7ebd77cc5f70a2f6bde8fdd05d68694a0ce48ae9))

## 0.25.0 (2026-07-02)

Full Changelog: [v0.24.0...v0.25.0](https://github.com/sentdm/sent-dm-php/compare/v0.24.0...v0.25.0)

### Features

* **api:** api update ([90808e6](https://github.com/sentdm/sent-dm-php/commit/90808e6f995430ffd000222afd154241ca0a967e))

## 0.24.0 (2026-06-30)

Full Changelog: [v0.23.0...v0.24.0](https://github.com/sentdm/sent-dm-php/compare/v0.23.0...v0.24.0)

### Features

* **api:** api update ([9b90725](https://github.com/sentdm/sent-dm-php/commit/9b907251a0683a94bb9d48a8c4e53dcb57e79399))
* **api:** api update ([b343626](https://github.com/sentdm/sent-dm-php/commit/b3436260c321335f3902a93ed9f8278e9a354423))

## 0.23.0 (2026-05-21)

Full Changelog: [v0.22.0...v0.23.0](https://github.com/sentdm/sent-dm-php/compare/v0.22.0...v0.23.0)

### Features

* **api:** api update ([3bebf6b](https://github.com/sentdm/sent-dm-php/commit/3bebf6bd3f6e07dbb691fe518fa39306a0fd2e78))
* **api:** api update ([dcb800d](https://github.com/sentdm/sent-dm-php/commit/dcb800de8105dcd760e06118cd905c177f658fbf))

## 0.22.0 (2026-05-14)

Full Changelog: [v0.21.0...v0.22.0](https://github.com/sentdm/sent-dm-php/compare/v0.21.0...v0.22.0)

### Features

* **api:** manual updates ([e7f9964](https://github.com/sentdm/sent-dm-php/commit/e7f9964b137a80c935d2b65250e96292109eecef))

## 0.21.0 (2026-05-14)

Full Changelog: [v0.20.2...v0.21.0](https://github.com/sentdm/sent-dm-php/compare/v0.20.2...v0.21.0)

### Features

* **api:** api update ([7f1cdc0](https://github.com/sentdm/sent-dm-php/commit/7f1cdc0d88f2c6b81252c138940a27f1d63c7ce6))

## 0.20.2 (2026-05-12)

Full Changelog: [v0.20.1...v0.20.2](https://github.com/sentdm/sent-dm-php/compare/v0.20.1...v0.20.2)

### Bug Fixes

* guzzle requires special handling to enable streaming ([3ba6140](https://github.com/sentdm/sent-dm-php/commit/3ba6140d55fd5db0768fcc09291e476a11f4a5b1))

## 0.20.1 (2026-04-29)

Full Changelog: [v0.20.0...v0.20.1](https://github.com/sentdm/sent-dm-php/compare/v0.20.0...v0.20.1)

## 0.20.0 (2026-04-29)

Full Changelog: [v0.19.0...v0.20.0](https://github.com/sentdm/sent-dm-php/compare/v0.19.0...v0.20.0)

### Features

* **api:** api update ([e903afc](https://github.com/sentdm/sent-dm-php/commit/e903afc858f78010070f9df4c616bb37bc300eb7))

## 0.19.0 (2026-04-29)

Full Changelog: [v0.18.0...v0.19.0](https://github.com/sentdm/sent-dm-php/compare/v0.18.0...v0.19.0)

### Features

* **api:** manual updates ([52241e4](https://github.com/sentdm/sent-dm-php/commit/52241e4f513da07c45b38ee811d0625954216a2a))

## 0.18.0 (2026-04-29)

Full Changelog: [v0.17.0...v0.18.0](https://github.com/sentdm/sent-dm-php/compare/v0.17.0...v0.18.0)

### Features

* support setting headers via env ([9ea33e1](https://github.com/sentdm/sent-dm-php/commit/9ea33e1b1c715502027712c71d5c8d15c26dd1c8))


### Bug Fixes

* revert enum parsing change that lead to unconditional failure ([ae15add](https://github.com/sentdm/sent-dm-php/commit/ae15addc2c6334d584b8acc0e94a138b87ec9648))

## 0.17.0 (2026-04-21)

Full Changelog: [v0.16.0...v0.17.0](https://github.com/sentdm/sent-dm-php/compare/v0.16.0...v0.17.0)

### Features

* **api:** api update ([60f33cb](https://github.com/sentdm/sent-dm-php/commit/60f33cb182159f04db0e5f57522e9bf2f2e95c98))

## 0.16.0 (2026-04-20)

Full Changelog: [v0.15.2...v0.16.0](https://github.com/sentdm/sent-dm-php/compare/v0.15.2...v0.16.0)

### Features

* **api:** api update ([e0b76bf](https://github.com/sentdm/sent-dm-php/commit/e0b76bf68faba34776470405778c6d6e9ab82dda))

## 0.15.2 (2026-04-20)

Full Changelog: [v0.15.1...v0.15.2](https://github.com/sentdm/sent-dm-php/compare/v0.15.1...v0.15.2)

### Bug Fixes

* **client:** resolve serialization issue with unions and enums ([7531884](https://github.com/sentdm/sent-dm-php/commit/75318844ced05775a1e0fd5f5864d0086f2ec480))
* populate enum-typed properties with enum instances ([033c91f](https://github.com/sentdm/sent-dm-php/commit/033c91f84a5673662f4bf0baad027e8fd86d32f6))

## 0.15.1 (2026-04-14)

Full Changelog: [v0.15.0...v0.15.1](https://github.com/sentdm/sent-dm-php/compare/v0.15.0...v0.15.1)

### Bug Fixes

* **client:** properly generate file params ([710aab9](https://github.com/sentdm/sent-dm-php/commit/710aab9f400a6782b26f3558e1daee112e1177b0))

## 0.15.0 (2026-04-07)

Full Changelog: [v0.14.0...v0.15.0](https://github.com/sentdm/sent-dm-php/compare/v0.14.0...v0.15.0)

### Features

* **api:** api update ([f13baaa](https://github.com/sentdm/sent-dm-php/commit/f13baaa1042a2380f3a8d57b3d59c29a53740424))

## 0.14.0 (2026-03-31)

Full Changelog: [v0.13.0...v0.14.0](https://github.com/sentdm/sent-dm-php/compare/v0.13.0...v0.14.0)

### Features

* **api:** manual updates ([db2cfed](https://github.com/sentdm/sent-dm-php/commit/db2cfed2d9237b20b5b4c346f017654ee1353080))

## 0.13.0 (2026-03-25)

Full Changelog: [v0.12.1...v0.13.0](https://github.com/sentdm/sent-dm-php/compare/v0.12.1...v0.13.0)

### Features

* **api:** api update ([cb94787](https://github.com/sentdm/sent-dm-php/commit/cb94787b9ae73bebf24b7e2a5b0e987d6dd36f48))
* **api:** api update ([2fd26c4](https://github.com/sentdm/sent-dm-php/commit/2fd26c4a48597b52d3cb2d90bbddffea0c7a3c01))

## 0.12.1 (2026-03-17)

Full Changelog: [v0.12.0...v0.12.1](https://github.com/sentdm/sent-dm-php/compare/v0.12.0...v0.12.1)

### Chores

* **internal:** tweak CI branches ([3b2b59b](https://github.com/sentdm/sent-dm-php/commit/3b2b59b809cd2e56f97960a32463ff60bb126666))

## 0.12.0 (2026-03-16)

Full Changelog: [v0.11.0...v0.12.0](https://github.com/sentdm/sent-dm-php/compare/v0.11.0...v0.12.0)

### Features

* **api:** api update ([0aace80](https://github.com/sentdm/sent-dm-php/commit/0aace809c1d086b7bfb119c576fc1d61436c8d09))

## 0.11.0 (2026-03-12)

Full Changelog: [v0.10.0...v0.11.0](https://github.com/sentdm/sent-dm-php/compare/v0.10.0...v0.11.0)

### Features

* **api:** manual updates ([2810a32](https://github.com/sentdm/sent-dm-php/commit/2810a3262f0ed0a83e6318e2d47c60524a66baaa))

## 0.10.0 (2026-03-12)

Full Changelog: [v0.9.0...v0.10.0](https://github.com/sentdm/sent-dm-php/compare/v0.9.0...v0.10.0)

### Features

* **api:** api update ([17068e4](https://github.com/sentdm/sent-dm-php/commit/17068e47e8cfdbca96116fe033041587d8215ee3))
* **api:** manual updates ([7766a76](https://github.com/sentdm/sent-dm-php/commit/7766a76f0539b56a806fcb2cd040399558bed4ee))
* **api:** manual updates ([c5d685d](https://github.com/sentdm/sent-dm-php/commit/c5d685dc51c6d9e147e05ff6e3b8694759875974))

## 0.9.0 (2026-03-11)

Full Changelog: [v0.8.0...v0.9.0](https://github.com/sentdm/sent-dm-php/compare/v0.8.0...v0.9.0)

### Features

* **api:** manual updates ([5b7e7f4](https://github.com/sentdm/sent-dm-php/commit/5b7e7f43256893878fb4e7e62a97693dd7bc131d))

## 0.8.0 (2026-03-11)

Full Changelog: [v0.7.0...v0.8.0](https://github.com/sentdm/sent-dm-php/compare/v0.7.0...v0.8.0)

### Features

* **api:** manual updates ([bbd3c51](https://github.com/sentdm/sent-dm-php/commit/bbd3c51ac80d1fba5be5a47eaf9585443b077999))

## 0.7.0 (2026-03-11)

Full Changelog: [v0.6.1...v0.7.0](https://github.com/sentdm/sent-dm-php/compare/v0.6.1...v0.7.0)

### Features

* **api:** api update ([f376b87](https://github.com/sentdm/sent-dm-php/commit/f376b87a15f19138b7026a65b974f08814362aac))

## 0.6.1 (2026-03-11)

Full Changelog: [v0.6.0...v0.6.1](https://github.com/sentdm/sent-dm-php/compare/v0.6.0...v0.6.1)

### Chores

* **internal:** codegen related update ([11c56a2](https://github.com/sentdm/sent-dm-php/commit/11c56a20603b0f7bd60da2e7d3762eec1f19a4c3))
* **internal:** upgrade phpunit ([516d9e8](https://github.com/sentdm/sent-dm-php/commit/516d9e8d332e45e6aad04cdecebffc39af6814ae))

## 0.6.0 (2026-02-18)

Full Changelog: [v0.5.0...v0.6.0](https://github.com/sentdm/sent-dm-php/compare/v0.5.0...v0.6.0)

### Features

* **api:** manual updates ([9323427](https://github.com/sentdm/sent-dm-php/commit/932342749a404a578e33197f96db275c5f033566))
* **api:** manual updates ([4431f76](https://github.com/sentdm/sent-dm-php/commit/4431f7632e01a09c30a070855f9637c38d4aba9c))
* **api:** manual updates ([e311a74](https://github.com/sentdm/sent-dm-php/commit/e311a7442015709e9119ae978af47fdc1bc5f4c7))

## 0.5.0 (2026-02-16)

Full Changelog: [v0.4.0...v0.5.0](https://github.com/sentdm/sent-dm-php/compare/v0.4.0...v0.5.0)

### Features

* **api:** manual updates ([4a5562a](https://github.com/sentdm/sent-dm-php/commit/4a5562add9477a3358a60cf23f45a6c9e16745cc))

## 0.4.0 (2026-02-10)

Full Changelog: [v0.3.0...v0.4.0](https://github.com/sentdm/sent-dm-php/compare/v0.3.0...v0.4.0)

### Features

* **api:** api update ([596184b](https://github.com/sentdm/sent-dm-php/commit/596184b88fd740050e97ee0516ef42328ef8481c))

## 0.3.0 (2026-02-04)

Full Changelog: [v0.2.2...v0.3.0](https://github.com/sentdm/sent-dm-php/compare/v0.2.2...v0.3.0)

### Features

* use `$_ENV` aware getenv helper ([fd90ce5](https://github.com/sentdm/sent-dm-php/commit/fd90ce5dfe166c4fc95f8eae14eb323867450ac1))


### Chores

* **internal:** php cs fixer should not be memory limited ([b39580a](https://github.com/sentdm/sent-dm-php/commit/b39580a339d376351d09bf27bc3984277a084978))

## 0.2.2 (2026-01-31)

Full Changelog: [v0.2.1...v0.2.2](https://github.com/sentdm/sent-dm-php/compare/v0.2.1...v0.2.2)

### Bug Fixes

* used redirect count instead of retry count in base client ([03e3921](https://github.com/sentdm/sent-dm-php/commit/03e392189b376b7db15d6feb04bb148510cd9095))

## 0.2.1 (2026-01-30)

Full Changelog: [v0.2.0...v0.2.1](https://github.com/sentdm/sent-dm-php/compare/v0.2.0...v0.2.1)

### Chores

* **internal:** ignore stainless-internal artifacts ([6225030](https://github.com/sentdm/sent-dm-php/commit/62250305adb0cafe5e29574bc9244da3850d53db))

## 0.2.0 (2026-01-28)

Full Changelog: [v0.1.0...v0.2.0](https://github.com/sentdm/sent-dm-php/compare/v0.1.0...v0.2.0)

### Features

* **api:** manual updates ([c911f5b](https://github.com/sentdm/sent-dm-php/commit/c911f5b43d5d11b2ca840bad5fc09633ab2e9dd5))

## 0.1.0 (2026-01-28)

Full Changelog: [v0.0.1...v0.1.0](https://github.com/sentdm/sent-dm-php/compare/v0.0.1...v0.1.0)

### Features

* **api:** manual updates ([04e7fc2](https://github.com/sentdm/sent-dm-php/commit/04e7fc2b7e177125311f4470482904d3dcc2153a))


### Chores

* sync repo ([e7459cf](https://github.com/sentdm/sent-dm-php/commit/e7459cf80e8d277ed419b62b1d1bef7953155be3))
* update SDK settings ([d32847a](https://github.com/sentdm/sent-dm-php/commit/d32847a3dfe4e7309ffc5792da3731692b19c809))
