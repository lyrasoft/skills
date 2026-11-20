# 修改 Bootstrap 變數、自定義顏色

- [修改變數](#id-修改bootstrap變數自定義顏色-修改變數)
  - [增加新的主色](#id-修改bootstrap變數自定義顏色-增加新的主色)
  - [增加新的 CSS 顏色變數](#id-修改bootstrap變數自定義顏色-增加新的css顏色變數)
  - [調整各類元件參數](#id-修改bootstrap變數自定義顏色-調整各類元件參數)
  - [自訂更多變數](#id-修改bootstrap變數自定義顏色-自訂更多變數)
- [使用函式](#id-修改bootstrap變數自定義顏色-使用函式)
  - [善用 SCSS 函式](#id-修改bootstrap變數自定義顏色-善用scss函式)
  - [善用 Bootstrap 函式](#id-修改bootstrap變數自定義顏色-善用bootstrap函式)
- [修改 class 樣式](#id-修改bootstrap變數自定義顏色-修改class樣式)
- [自訂更多實用class](#id-修改bootstrap變數自定義顏色-自訂更多實用class)
  - [擴充現有的實用 class](#id-修改bootstrap變數自定義顏色-擴充現有的實用class)
  - [建立自己的新 class (用 $utilities)](#id-修改bootstrap變數自定義顏色-建立自己的新class用utilities)
  - [建立自己的新 class (手動迴圈)](#id-修改bootstrap變數自定義顏色-建立自己的新class手動迴圈)
- [善用 CSS3 變數](#id-修改bootstrap變數自定義顏色-善用css3變數)
- [其他常見問題](#id-修改bootstrap變數自定義顏色-其他常見問題)
  - [按鈕文字變黑色](#id-修改bootstrap變數自定義顏色-按鈕文字變黑色)

# 修改變數

我們的[標準 SCSS 結構](https://github.com/lyrasoft/outsource-layout-template/tree/main/resources/assets/scss)中有一個 `_variables.scss` 檔案：

```sass
// Pre-define variables

@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/variables-dark";
@import "bootstrap/scss/mixins";
@import "bootstrap/scss/maps";

// Override variables

@import "bootstrap/scss/maps";
```

bootstrap的變數都放在 `bootstrap/scss/variables` 的這個檔案中,

可以到裡面搜尋想替換的變數

![](../../attachments/715387b2-9102-4f7b-b5a1-340c4687bf99.png)

例如想替換 `$primary` 的顏色的話 在 `_variables.scss` 的 `@import` 前面修改變數內容即可

```sass
$primary: #d96ed9;

@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/variables-dark";
@import "bootstrap/scss/mixins";
@import "bootstrap/scss/maps";

@import "bootstrap/scss/maps";
```

成功變色

![](../../attachments/6714bcce-0b76-4638-8ceb-cff7eaa5e4fb.jpg)

## 增加新的主色

theme colors 是 bootstrap 建立好的顏色 class 例如 `text-primary、bg-primary、btn-primary` 這些都會依照你的 `$primary` 變數去建立相對應的顏色出來,如果想增加新的內容的話, 在 `_variables.scss` 的 `@import` 前增加自訂義的顏色變數然後在 `@improt` 後增加以下內容

```sass
// Override variables
$facebook: #4267B2;

@import "./node_modules/bootstrap/scss/functions";
@import "./node_modules/bootstrap/scss/variables";
@import "./node_modules/bootstrap/scss/mixins";

// Override maps
$theme-colors:map-merge($theme-colors, (
  "facebook": $facebook
));

@import "./node_modules/bootstrap/scss/maps";
```

![](../../attachments/a9395619-286a-4030-b6ca-4621fcceca7d.jpg)

更完整的範例，讓 CSS 變數與 rgb 參數都一起增加

```sass
$gray: #8B8B8B;
$orange: #FF7246;
$facebook: #4267B2;

@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/variables-dark";
@import "bootstrap/scss/mixins";
@import "bootstrap/scss/maps";

// 自定義的theme colors
$custom-theme-colors: (
  'gray': $gray,
  'orange': $orange,
  'facebook': $facebook,
);

// 合併 bootstrap預設的顏色及自訂義顏色
$theme-colors: map-merge($theme-colors, $custom-theme-colors);

// 轉換成 rgb
$theme-colors-rgb: map-loop($theme-colors, to-rgb, "$value");

// utilities colors 用來編譯 文字及背景顏色用
// 合併 bootstrap預設的 rgb 顏色及自訂義的 rgb 顏色
$utilities-colors: map-merge($theme-colors-rgb, $utilities-colors);

// 編譯 文字顏色
$utilities-text-colors: map-loop(
    $utilities-colors,
    rgba-css-var, "$key", "text"
);

// 編譯 背景顏色 
$utilities-bg-colors: map-loop($utilities-colors, rgba-css-var, "$key", "bg");

@import "bootstrap/scss/maps";
```

## 增加新的 CSS 顏色變數

在 includes 的後方，merge `$colors` 變數

```sass
// ...

@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/variables-dark";
@import "bootstrap/scss/mixins";
@import "bootstrap/scss/maps";

$colors: map-merge($colors, (
  'light-blue': $light-blue,
  'golden': $golden,
  'golden-light': $golden-light,
));

// ...

@import "bootstrap/scss/maps";
```

就可以在 CSS 裡面使用了

![](../../attachments/7ed5f262-fc33-4670-abd2-a1e1881c70c0.jpg)

## 調整各類元件參數

根據專案需要，調整一些常用元件的圓角或框線等參數

```sass
// Link
$link-decoration: none;

// Card
$card-border-radius: 15px;

// Button
$btn-border-radius: 5px;

// Form
$input-border-width: 0;

@import "./node_modules/bootstrap/scss/functions";
@import "./node_modules/bootstrap/scss/variables";
```

## 自訂更多變數

妳也可以自訂專案專用的變數

```sass
$title-font: 'Roboto', 'PingFang TC', 'Heiti TC', '微軟正黑體', sans-serif;
```

只要是在 SCSS 內任何地方都可以使用

```sass
// components/_card.scss
.card {
  .card-title {
    font-family: $title-font;
    color: $primary;
  }
}
```

# 使用函式

## 善用 SCSS 函式

例如 darken() 可以讓 hover 顏色變身

```sass
a {
  color: $primary;

  &:hover {
    color: darken($primary, 5%);
  }
}
```

See <https://sass-lang.com/documentation/at-rules/function>

## 善用 Bootstrap 函式

Bootstrap 的 `_functions.scss` 也提供大量函式與 mixin，可以善用。立如果想要立刻增加一個自訂按鈕的樣式，下面這個 button-variant mixin 可以幫我快速設定好背景顏色、框線、 hover 顏色等等。

```sass
.btn-custom {
  @include button-variant(#581493);
}
```

# 修改 class 樣式

如果有些樣式無法靠變數修改，但是全站共用，可以覆蓋 BS 內建 class。

例如所有按鈕都要漸變的話，可以寫在 `.btn` 上

```java
.btn {
  transition: ...;
}
```

但如果某個區塊的 btn 有特殊樣式，最好是用額外的 class 來做

<font style="color: #bf2600;">錯誤</font>

```sass
.about-page {
  .btn {
    // ...
  }
}
```

<font style="color: #36b37e;">正確</font>

```sass
.about-page {
  .btn--more {
    // ...
  }
}
```

# 自訂更多實用class

有時候，我們需要自訂一系列 `foo-1` ~ `foo-6` 的 class 來用，或是把現有的 spacers 擴充之類的，可以這樣做

## 擴充現有的實用 class

比如果我們希望把 `mt-x` 擴充到 6,7,8,9 的大小，可以這樣做

```sass
// _variables.scss
// ...
@import "./node_modules/bootstrap/scss/functions";
@import "./node_modules/bootstrap/scss/variables";
@import "./node_modules/bootstrap/scss/mixins";
@import "./node_modules/bootstrap/scss/maps";

$spacers: map-merge(
  (
    6: ($spacer * 6),
    7: ($spacer * 12),
    8: ($spacer * 24),
  ),
  $spacers,
);

```

輸出結果如下

![](../../attachments/59d084f2-5e0f-416b-a2b9-eab21c2e352a.jpg)

## 建立自己的新 class (用 $utilities)

用 `$utilities` 變數，可以自訂自己的新 class 與級距

```sass
// _variables.scss
// ...
@import "./node_modules/bootstrap/scss/functions";
@import "./node_modules/bootstrap/scss/variables";
@import "./node_modules/bootstrap/scss/mixins";
@import "./node_modules/bootstrap/scss/maps";

$utilities: (
  'ft' : (
    property: font-size,
    class: ft,
    values: (
      64: 4rem,
      58: 3.6rem
      // ...
    )
  )
);
```

## 建立自己的新 class (手動迴圈)

```sass
// _variables.scss
$my-sizes: (
  xl: 1,
  lg: 2,
  md: 3,
  sm: 4,
  xl: 5
);
```

```sass
// _my-sizes.scss
@each $index, $value in $mys-sizes {
  .mysize-#{$index} {
    font-size: #{$value}px;
    font-weight: calc(100 * #{$value});
  }
}

```

# 善用 CSS3 變數

Bootstrap 會把一系列顏色等參數輸出成 CSS 變數，這些變數的好處是隨時可用，不會受限於 SCSS 內

![](../../attachments/ea5b8493-b8c6-49b7-90f7-1559e6c922ae.jpg)

使用變數

```sass
color: var(--bs-primary);
```

當你偶爾要把CSS寫在模板上時，CSS 變數就能派上用場

```html
<style>
  .foo {
    color: var(--bs-primary);
  }
</style>
```

你也可以自訂自己的 CSS 變數

```sass
// 在 _variables.scss 內
:root {
  --my-color: #f5f5f5;
  --banner-bg: #{$primary}; // <-- 插入 SCSS 變數給 CSS 變數
}
```

如果你想要用 CSS 變數的顏色來做 rgba 半透明，必須用 rgb 版本

```sass
.foo {
  background-color: rgba(var(--bs-primary-rgb), .5);  // 有效
  background-color: rgba(var(--bs-primary), .5);  // 無效
}
```

可以用 SCSS 函式做 RGB 轉換

```sass
$special-color: #D18B3B;
:root {
  --special-color: #{$special-color};
  --special-color-rgb: #{to-rgb($special-color)};
}
```

# 其他常見問題

## 按鈕文字變黑色

有時會碰到設計師的主色比較淺一些，BS 自動把文字轉呈黑色。

![](../../attachments/637e7970-6bac-4c5c-8f10-c09efd115e81.jpg)

可以在 `_variables.scss` 內把變數 `$min-contrast-ratio` 設定成 4.5 以下，我常用的是 2.7-3 之間

```sass
$min-contrast-ratio: 2.8;
```

這樣就可以把黑色文字的門檻降低，使按鈕文字變回白色

![](../../attachments/bd09db21-ec42-437a-871a-25d77cf810a9.jpg)
