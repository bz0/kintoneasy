# kintoneasy
kintone APIを簡単に使えるようにするライブラリです。
レコードの操作を行うことができます。

# 動作環境

PHP5.3以上

# 使い方

## 基本的な使い方

### 1.初期設定

利用したいkintoneのサブドメイン、アプリの指定を行います。

```php
kintoneasy\client::$config = array(
    "subdomain" => "", //サブドメインを指定
    "token"     => "", //APIトークンを指定
    "app"       => 1   //アプリIDを指定
);
```

### 2.レコードの操作

「$content」でリクエストボディの指定を行い、リクエストを行います。

リクエストボディの詳細については、下記を参照下さい。
https://developer.cybozu.io/hc/ja/articles/202166160

```php
//レコードを１件取得
$content = array(
    "app" => 1,
    "id"  => 1
);

$client = new kintoneasy\client();
$res    = $client->method('get')->record($content);
```

## レコードの取得

### 1件取得

レコードIDを指定して、レコードを１件取得します。

```php
$content = array(
    "app" => 1,
    "id"  => 1003
);

$client = new kintoneasy\client();
$res    = $client->method('get')->record($content);
```

### 複数件取得

クエリを指定して複数件取得します。

```php
$content = array(
    "query" => "no >= 950 order by no asc",
    "totalCount" => true
);

$client = new kintoneasy\client();
$res    = $client->method('get')->records($content);
```

## レコードの登録

### 1件登録

```php
$content = array(
    "record" => array(
        'no' => array(
            "value" => 11111
        ),
        'name' => array(
            "value" => "aaaaaa"
        )
    )
);

$client = new kintoneasy\client();
$res    = $client->method('post')->record($content);
```

### 複数件登録

```php
$content = array(
    "records" => array(
        array(
            'no' => array(
                "value" => 11111
            ),
            'name' => array(
                "value" => "aaaaaa"
            )
        ),
        array(
            'no' => array(
                "value" => 22222
            ),
            'name' => array(
                "value" => "bbbbbb"
            )
        )
    )
);

$client = new kintoneasy\client();
$res    = $client->method('post')->records($content);
```

## レコードの更新

### 1件更新

```php
$content = array(
    "app" => 1,
    "id"  => 2000,
    "record" => array(
        "name" => array(
            "value" => "aaaaaaaaaaaaaaaaa"
        )
    )
);

$client = new kintoneasy\client();
$res    = $client->method('put')->record($content);
```

### 複数件更新

```php
$content = array(
    "app" => 1,
    "records" => array(
        array(
            "id"  => 2000,
            "name" => array(
                "value" => "aaaaaaaaaaaaaaaaa"
            )
        ),array(
            "id"  => 1999,
            "name" => array(
                "value" => "bbbbbbbbbbbbbbbbb"
            )
        )
    )
);

$client = new kintoneasy\client();
$res    = $client->method('put')->records($content);
```
## レコードの削除

### 1件削除

```php
$content = array(
    "app" => 1,
    "ids" => array_values(array("1009"))
);

$client = new kintoneasy\client();
$res    = $client->method('delete')->records($content);
```

### 複数件削除

```php
$content = array(
    "app" => 1,
    "ids" => array_values(array("1007","1008"))
);

$client = new kintoneasy\client();
$res    = $client->method('delete')->records($content);
```
