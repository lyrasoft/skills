# CSS / SCSS 標準規範

- [使用 Bootstrap 5 並客製化編譯](#cssscss標準規範-使用bootstrap5並客製化編譯)
- [SCSS 結構](#cssscss標準規範-scss結構)
  - [覆蓋 Bootstrap 變數](#cssscss標準規範-覆蓋bootstrap變數)
  - [主要入口](#cssscss標準規範-主要入口)
  - [元件與頁面](#cssscss標準規範-元件與頁面)
  - [頁面包覆](#cssscss標準規範-頁面包覆)
    - [VitePress 作法](#cssscss標準規範-vitepress作法)
  - [範例檔案](#cssscss標準規範-範例檔案)
- [Design System](#cssscss標準規範-designsystem)
- [品質政策](#cssscss標準規範-品質政策)

# 使用 Bootstrap 5 並客製化編譯

夏木樂統一使用 Bootstrap 5 作為所有網站的基底，您必須熟悉多數 Bootstrap 元件的基礎用法，並使用良好的 flex 結構編寫 HTML。

我們<font style="color: #bf2600;">要求所有網站的 Bootstrap 都要根據該專案風格，改寫變數，然後重新編譯</font>。因此請不要引入原始的 bootstrap CSS 然後寫大量的覆蓋 CSS，請使用 `sass` 工具進行編譯。

<https://getbootstrap.com/>

# SCSS 結構

夏木樂採用 SCSS 編寫網站 CSS，您必須遵守我們的結構安排。主要結構請見 <https://github.com/lyrasoft/outsource-layout-template/tree/main/resources/assets/scss> 可以直接下載。

![screenshot 2025-02-18 下午2.30.35.jpg](../../attachments/510d0481-11a1-470e-889e-f79811cea5ab.jpg)

## 覆蓋 Bootstrap 變數

編寫時，請勿直接覆蓋 Bootstrap 樣式，舉例來說，<font style="color: #bf2600;">請不要像這樣覆蓋按鈕的樣式</font>：

```sass
// 錯誤作法
.btn-primary {
  background: #FF6666;
  border: 1px solid #FF6666;
  border-radius: 8px;
  
  &:hover {
    background: #e66363;    
  }
}
```

<font style="color: #36b37e;">正確作法</font>，使用 \_variables.scss 內的變數覆蓋

```sass
$primary: #355B81;

$btn-border-radius: 8px;

// ...
```

<font style="color: #36b37e;">正確作法</font>，變數改不到，但確定全站共用的樣式可以覆蓋

```sass
.btn {
  transition: ...;
}

.card {
  animation: ...;
}
```

詳細覆蓋方式請見[修改 Bootstrap 變數、自定義顏色](修改%20Bootstrap%20變數、自定義顏色.md)

## 主要入口

> [!IMPORTANT]
> 以下的項目模版已經準備好，但我們還是解釋一下結構設計

SCSS 結構中有一個 `main.scss` 檔案，所有網站頁面都要統一載入這個 CSS。

裡面包含了自定義的變數檔案，與 Bootstrap 主檔案。樣 bootstrap 就整個被包含進來了。如此就能編譯出擁有自定義顏色與參數的 Bootstrap。

```java
// Variables
@import "variables";

// Bootstrap Main File
@import "bootstrap/scss/bootstrap";

// Components & Pages ...
```

嘗試編譯看看

```java
sass scss/main.scss css/main.css --load-path=node_modules
```

就會將 Bootstrap 連同網站樣式全部輸出到一個檔案中。

如果您沒有用 gulp / webpack 之類的工具，可以單純用 `sass` 指令編譯就好

以下是監聽檔案修改自動編譯的指令

```java
sass scss/main.scss css/main.css --load-path=node_modules --watch
```

如果您是用 vitepress ，請見 [Github 專案初始化](../Github%20相關/Github%20專案初始化.md)

## 元件與頁面

我們分成幾個常用的資料夾

- base => 專案的基礎樣式
- components => 可重複使用的元件樣式
- layout => 專案的版面樣式
- pages => 每個頁面的樣式

因此您的 `main.scss` 寫到後來會長這樣

```sass
// Variables
@import "variables";
@import "bootstrap/scss/bootstrap";

// Base
@import "base/base";
@import "base/typography";
@import "base/utilities";
@import "base/extended";

// Component
@import "components/breadcrumb";
@import "components/contact-form";
@import "components/buttons";
@import "components/form";
@import "components/deco";
@import "components/nav";
@import "components/card";
@import "components/pagination";

// Layout
@import "layout/base";
@import "layout/header";
@import "layout/banner";
@import "layout/footer";

// Pages
@import "pages/home";
@import "pages/about";
@import "pages/article-list";
@import "pages/article-item";
@import "pages/contact";
@import "pages/login";
```

請參考真實範例： <https://github.com/lyrasoft/arendelle-static/tree/staging/.vaseman/resources/assets/scss>

## 頁面包覆

所有頁面統一引入到 main.scss 裡面，並且用一個外層選擇器包起來

```java
// pages/_about.scss

.page-about {
  // 這裡寫所有這頁的的 CSS
}
```

在 HTML 上，如果您的編譯軟體支援，請將包覆的 class 寫在 body 上

```html
<body class="page-about">
  ...
</body>
```

請不要對這個外層包覆 class 下樣式或當成 BEM block，因為後續都會被換掉

<font style="color: #bf2600;">錯誤</font>

`page-about` 對整個頁面的 CSS 感染，後續無法更換 scope 名稱。

另外內部的區塊過度濫用 BEM elements，無法跨頁面共用。

```sass
.page-about {
  padding: 3rem;
  background: white;

  &__header {}

  &__title {}

  &__body {}

  &__content {}
}
```

<font style="color: #006644;">正確</font>

讓包覆的 scope 本身獨立，不要感染整個頁面的 class。

內部每個區塊的命名也獨立，才能跨頁面共用。

```java
.page-about-wrapper {
  .page-about {
    padding: 3rem;
    background: white;
  
    .page-header {}
  
    .page-title {}
  
    .page-body {}
  
    .page-content {}
  }
}
```

### VitePress 作法

若您使用 VitePress，建議不要將樣式放在元件內的 style，雖然可以運作，但 Reviewer 可能沒有察覺你放的位置，所以建議依照規範統一放到 scss/pages 下面。

## 範例檔案

由於重複建立這些結構很費時，我們建立的標準包可以讓您直接下載使用

<https://github.com/lyrasoft/outsource-layout-template/tree/main/resources/assets/scss>

# Design System

移動至

[Design System 切版標準規範](Design%20System%20切版標準規範.md)

# 品質政策

請見切版常見錯誤，避免在專案中使用不正確的 HTML / CSS 格式

[HTML / CSS 優良寫法與常見錯誤](HTML%20_%20CSS%20優良寫法與常見錯誤.md)

Vue / Vitepress 開發者請多看這一份

[Vue / Vitepress 常見錯誤](Vue%20_%20Vitepress%20常見錯誤.md)
