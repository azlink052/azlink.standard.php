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

クラスや定数を使用する前にインポートしてから使用するか、最初に名前空間の一部をエイリアスでインポートし使用のたびにエイリアス名をつけるか、どちらかの方法で使用します。

##### インポートしてから使用する場合

使用するクラスや定数をファイルの先頭でインポートします。

[クラスの場合]

`use azlink\workspace\classes\Theme`

[定数の場合]

`use const azlink\workspace\config\HOME_URL`

その後はコード中に普通に使用できます。

```
echo HOME;
echo Trnsform::sanitizer($a);
```

※ /test.php を参照

##### 使用するたびエイリアス名をつける場合 

呼び出したいファイルの先頭で

`use azlink\workspace as azlib;`

とすることで、インポートした azlink\workspace を「azlib」に短縮できます。
その後はエイリアス名をつけて使用します。

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

これは FromError.php のswitch文内、「recruit」のエラー定義を使用することを意味します。

### GlobalError

エラー時特定のログを記録したりページ遷移させるなどの挙動を制御するクラス。主にアプリケーションで使用。

### MyWP

WordPressを導入するサイトで使用するクラスです。コンストラクタを実行することでWPが読み込まれます。
コンストラクタの引数に wp-config.php のパスを渡すことができます。(デフォルト値あり)

#### outputPagination

WPのページネーションを出力します。基本的な使い方は参考ソースを参照。

#### getNow

WPのタイムゾーン設定に合わせた現在時間を返します。返り値のフォーマットを指定できます。
