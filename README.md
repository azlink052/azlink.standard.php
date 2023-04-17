# azlink.standard.php

AZLINK.standard (PHP 版)のファイルセットです。
常に最新版になるよう管理するので基本的にはここからコードを取得して使ってください。
同名のグローバル定数を使用する別のアプリケーションとバッティングしないよう namespace を使用しています。

---

## 現在のパッケージ一覧

- classes ディレクトリ
  - common 汎用的にしようできるクラスディレクトリ
- config ディレクトリ
  - extendConfig.php 案件によって追加で定義したい定数を記述
- default ディレクトリ
  - defaultSite.php サイト内で共通で実行したい処理などを記述

## classes

汎用的に使用できる PHP のクラス群です。

### クラスリスト

以下は案件によって多少の書き換えが必要なことがあります。

- Autoload
- EntryHelper
- FileUpload
- FormError
- GlobalError
- MyWP
- Theme
- Transform

さらに汎用的なファイル群は common ディレクトリにあります。

- ArrayHelper
- Database
- FormHelper
- GenerateRandomString
- Image
- Log
- ~~QuotesTransform~~
- RequiredCheck
- SendMail
- Utilities

---

#### namespace 下での定数・クラス関数呼び出し

例えば

config/siteConfig.php

に書かれた SITE_NAME を呼び出す場合、

`azlink\workspace\config\SITE_NAME`

と記述することで呼び出すことができます。
ただこれでは長いのでショートカットを作成することができます。
呼び出したいファイルの先頭で

`use azlink\workspace as azlib;`

とすることで、azlink\workspace を「azlib」に短縮できます。

[定数の場合の例]

`azlib\config\SITE_NAME`

[関数の場合の例]

`azlib\classes\Trnsform::sanitizer($a)`

今後別のアプリケーションを追加する場合は azlink\workspace\ の名前空間に追加します。
例えば採用情報への申込みを管理するアプリケーションを追加する場合、

`azlink\workspace\recruit\`

に配置し、その中の定数を呼び出す場合は

`azlib\recruit\config\SITE_NAME`

のようになり、同じ azlink\workspace の名前空間に存在できることになります。

#### const と define の違い

define は名前空間に存在せずグローバルな定数、const は名前空間に定義することができる点が違います。
また define は関数の返り値や変数を指定できるけど const はできないので使い分けが必要です。

---

### Autoload

このファイルを require しインスタンスを作成(コンストラクタを実行)することで、各クラスを都度 require することなく使用できるようになります。
この処理は /default/default.php で行っています。

`$autoload = new azlib\classes\Autoload;`

### EntryHelper

サイト内固有の処理を書くことを想定。
例えばファイル拡張子に対して指定した css クラス名を返す処理など。

### FileUpload

フォームから送信されたものをサーバ上にアップロードためのクラス。
※詳細は後日

### FormError

フォームの入力結果に対応したエラー文を返すクラス。
フォームが複数ある場合はコンストラクタ内の switch 文に追加する。

■ FormError.php

```
switch ($menu) {
  case 'contact':
    $this->errorArgs = [
      'nameEmpty' 	=> azlib\config\ERR_NAME_EMPTY
    ];
    break;
  case 'recruit':
    $this->errorArgs = [
      'mailEmpty' 	=> azlib\config\ERR_MAIL_EMPTY
    ];
    break;
}
```

■ フォームファイル側

`$formError = new FormError($requiredCheckResult, 'recruit');`

### GlobalError

エラー時特定のログを記録したりページ遷移させるなどの挙動を制御するクラス。主にアプリケーションで使用。
