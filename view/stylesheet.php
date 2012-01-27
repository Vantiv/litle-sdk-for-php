<?php header("Content-type: text/css"); ?>
/* =============================================================================
   Configuration and mixins
   ========================================================================== */

@mixin border-radius($radius) {
  -webkit-border-radius: $radius;
  -moz-border-radius: $radius;
  border-radius: $radius;
}

@mixin border-radius-top($radius) {
  @include border-radius-top-left($radius);
  @include border-radius-top-right($radius);
}

@mixin border-radius-right($radius) {
  @include border-radius-top-right($radius);
  @include border-radius-bottom-right($radius);
}

@mixin border-radius-bottom($radius) {
  @include border-radius-bottom-right($radius);
  @include border-radius-bottom-left($radius);
}

@mixin border-radius-left($radius) {
  @include border-radius-top-left($radius);
  @include border-radius-bottom-left($radius);
}

@mixin border-radius-top-right($radius) {
  -webkit-border-top-right-radius: $radius;
  -moz-border-radius-topright: $radius;
  border-top-right-radius: $radius;
}

@mixin border-radius-bottom-right($radius) {
  -moz-border-radius-bottomright: $radius;
  -webkit-border-bottom-right-radius: $radius;
  border-bottom-right-radius: $radius;
}

@mixin border-radius-bottom-left($radius) {
  -moz-border-radius-bottomleft: $radius;
  -webkit-border-bottom-left-radius: $radius;
  border-bottom-left-radius: $radius;
}

@mixin border-radius-top-left($radius) {
  -moz-border-radius-topleft: $radius;
  -webkit-border-top-left-radius: $radius;
  border-top-left-radius: $radius;
}

@mixin box-shadow($shadow) {
  -webkit-box-shadow: $shadow;
  -moz-box-shadow: $shadow;
  box-shadow: $shadow;
}

/* Font stacks
   -------------------------------------------------------------------------- */

$body-font-stack: "Helvetica Neue", sans-serif;
$heading-font-stack: Futura, 'Trebuchet MS', 'Helvetica Neue', sans-serif;

/* Grid
   -------------------------------------------------------------------------- */

$desktop_grid_unit: 60px;
$desktop_grid_gutter: 20px;
$desktop_input_padding: 18px;

$baseline_height: 24px;

@function desktop_grid_width($n) {
  @return $n * $desktop_grid_unit + ($n - 1) * $desktop_grid_gutter;
}

/* Colors
   -------------------------------------------------------------------------- */

$samurai-grey: #232d33;
$samurai-light-grey: #94A0A8;
$samurai-red: #bf3d30;
$samurai-orange: #d7814c; 
$samurai-teal: #587f87;
$samurai-blue: #244e75;
$samurai-green: #6b9679;
$samurai-cream: #f5f4f2;

/* =============================================================================
   HTML5 element display
   ========================================================================== */

article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display: block; }
audio[controls], canvas, video { display: inline-block; *display: inline; *zoom: 1; }


/* =============================================================================
   Base
   ========================================================================== */

html { font-size: 100%; overflow-y: scroll; -webkit-tap-highlight-color: rgba(0,0,0,0); -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }

body { margin: 0; }

body, button, input, select, textarea { font-family: sans-serif; color: #232d33; }

::-moz-selection { background: #bf3e31; color: #fff; text-shadow: none; }
::selection { background: #bf3e31; color: #fff; text-shadow: none; }


/* =============================================================================
   Links
   ========================================================================== */

a { 
  color: #244e75; 
  color: #355f86; 
  color: #416992; 
}
a:visited { color: #3d6284; }
a:focus { outline: thin dotted; }

a:hover, a:active { color: #bf3d30; outline: 0; }


/* =============================================================================
   Typography
   ========================================================================== */

abbr[title] { border-bottom: 1px dotted; }

b, strong { font-weight: bold; }

blockquote { margin: 24px 0 24px 49px; }

dfn { font-style: italic; }

hr { display: block; clear: both; height: 0; line-height: 0; border: 0; border-top: 1px solid #E1E2E1; margin: 1em 0; padding: 0; }

ins { background: #ff9; color: #000; text-decoration: none; }

mark { background-color: transparent; color: #232d33; font-weight: bold; }

pre, code, kbd, samp { font-family: monospace, monospace; _font-family: 'courier new', monospace; font-size: 1em; }

pre { white-space: pre; }

q { quotes: none; }
q:before, q:after { content: ""; content: none; }

small { font-size: 85%; line-height: 1; }

sub, sup { font-size: 75%; line-height: 0; position: relative; vertical-align: baseline; }
sup { top: -0.5em; }
sub { bottom: -0.25em; }


/* =============================================================================
   Lists
   ========================================================================== */

ul, ol { margin: 1em 0; padding: 0 0 0 18px; }
dd { margin: 0 0 0 18px; }
/*nav ul, nav ol { list-style: none; margin: 0; padding: 0; }*/


/* =============================================================================
   Embedded content
   ========================================================================== */

img { border: 0; -ms-interpolation-mode: bicubic; }

svg:not(:root) { overflow: hidden; }


/* =============================================================================
   Figures
   ========================================================================== */

figure { margin: 0; }


/* =============================================================================
   Forms
   ========================================================================== */

form { margin: 0; }
fieldset { border: 0; margin: 0; padding: 0; }
legend { border: 0; *margin-left: -7px; padding: 0; }
label { cursor: pointer; }
button, input, select, textarea { font-size: 100%; margin: 0; vertical-align: baseline; *vertical-align: middle; }
button, input { line-height: normal; *overflow: visible; }
button, input[type="button"], input[type="reset"], input[type="submit"] { cursor: pointer; -webkit-appearance: button; }
input[type="checkbox"], input[type="radio"] { box-sizing: border-box; }
input[type="search"] { -moz-box-sizing: content-box; -webkit-box-sizing: content-box; box-sizing: content-box; }
button::-moz-focus-inner, input::-moz-focus-inner { border: 0; padding: 0; }
textarea { overflow: auto; vertical-align: top; }
input:valid, textarea:valid {  }
input:invalid, textarea:invalid { background-color: #f0dddd; }


/* =============================================================================
   Tables
   ========================================================================== */

table { border-collapse: collapse; border-spacing: 0; }

/* =============================================================================
   Grid 
   ========================================================================== */

@mixin input-width-from-grid-units($column) {
  width: $grid_unit * $column + $grid_gutter * ($column - 1) - $input_padding !important;
}

/* Mobile - 320px
   -------------------------------------------------------------------------- */
.wrapper {
  margin: 0 auto;
  width: 320px;
}

/* Sets up basic grid floating and margin. */
div.span-1, div.span-2, div.span-3, div.span-4, div.span-5, div.span-6, div.span-7, div.span-8, div.span-9, div.span-10, div.span-11, div.span-12,
.span-1, .span-2, .span-3, .span-4, .span-5, .span-6, .span-7, .span-8, .span-9, .span-10, .span-11, .span-12 {
  float: left;
  margin-right: 0;
}

/* The last column in a row needs this class. */
div.last, .last { margin-right: 0; }

/* Desktop
   -------------------------------------------------------------------------- */

$grid_unit: $desktop_grid_unit;
$grid_gutter: $desktop_grid_gutter;
$input_padding: $desktop_input_padding;

.wrapper {
  width: 940px;
}

/* Sets up basic grid floating and margin. */
div.span-1, div.span-2, div.span-3, div.span-4, div.span-5, div.span-6, div.span-7, div.span-8, div.span-9, div.span-10, div.span-11, div.span-12,
.span-1, .span-2, .span-3, .span-4, .span-5, .span-6, .span-7, .span-8, .span-9, .span-10, .span-11, .span-12 {
  float: left;
  margin-right: $grid_gutter;
}

/* The last column in a row needs this class. */
div.last, .last { margin-right: 0; }

/* Use these classes to set the width of a column. */

@for $i from 1 through 11 {
  .span-#{$i} { width: $grid_unit * $i + $grid_gutter * ($i - 1); }
}

.span-12, div.span-12 { width: $grid_unit * 12 + $grid_gutter * 11; margin: 0; }

@for $i from 1 through 12 {
  input.span-#{$i}, textarea.span-#{$i}, select.span-#{$i} { @include input-width-from-grid-units($i); }
}

@for $i from 1 through 12 {
  .button.span-#{$i} { width: $grid_unit * $i + $grid_gutter * ($i - 1) - 24px !important; }
  .small.button.span-#{$i} { width: $grid_unit * $i + $grid_gutter * ($i - 1) - 16px !important; }
  .big.button.span-#{$i} { width: $grid_unit * $i + $grid_gutter * ($i - 1) - 44px !important; }
}

/* Add these to a column to append empty cols. */
@for $i from 1 through 11 {
  .append-#{$i} { padding-right: $i * ($grid_unit + $grid_gutter); }
}

/* Add these to a column to prepend empty cols. */
@for $i from 1 through 11 {
  .prepend-#{$i} { padding-left: $i * ($grid_unit + $grid_gutter); }
}

@for $i from 1 through 11 {
  .prepend-#{$i}-unit { padding-left: $i * $grid_unit; }
}

/* Border on right hand side of a column. */
div.border, p.border {
  padding-right: 10px;
  margin-right: 9px;
  border-right: 1px solid #eeeeee;
}

/* Use these classes on an element to push it into the
   next column, or to pull it into the previous column.  */

@for $i from 1 through 12 {
  .pull-#{$i} { margin-left: -$i * ($grid_unit + $grid_gutter); }
}

@for $i from 1 through 12 {
  .push-#{$i} {
    margin: 0 (-$i * ($grid_unit + $grid_gutter)) 1.5em ($i * ($grid_unit + $grid_gutter));
  }
}

/* Styles common to all variations
   -------------------------------------------------------------------------- */

.pull-1, .pull-2, .pull-3, .pull-4, .pull-5, .pull-6, .pull-7, .pull-8, .pull-9, .pull-10, .pull-11, .pull-12 {
  float: left;
  position: relative;
}

.push-1, .push-2, .push-3, .push-4, .push-5, .push-6, .push-7, .push-8, .push-9, .push-10, .push-11, .push-12 {
  float: right;
  position: relative;
}
/* =============================================================================
   Globally applicable styles
   ========================================================================== */

/* Global
   -------------------------------------------------------------------------- */

body {
  background: #f5f4f2;
  background-image: url('../images/base/bg-bodypattern-clean.png');
  background-repeat: repeat;
  background-position: 50% 50%;
  color: #3f4243;
  font-family: $body-font-stack;
  font: 14px/21px $body-font-stack;
}


/* Headings
   -------------------------------------------------------------------------- */

h1, h2, h3, h4, h5, h6 {
  -webkit-font-smoothing: antialiased;
  font-family: $heading-font-stack;
  font-weight: 500;
}

h1 {
  font-size: 36px;
  line-height: 48px;
  margin: 0 0 24px;
  color: #232d33;

  &.tagline {
    font-weight: normal;
    text-transform: none;
    letter-spacing: 0;
    text-align: center;
  }
}

h2 {
  color: #bf3d30;
  font-size: 24px;
  line-height: 36px;
  margin: 0 0 24px 0;

  &.subtitle {
    font-size: 24px;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-weight: bold;
  }
}

h3 {
  color: #bf3d30;
  font-size: 20px;
  line-height: 24px;
  margin: 0 0 12px 0;
}

h4 {
  color: #587f87;
  text-transform: uppercase;
  line-height: 24px;
  font-size: 16px;
  font-weight: bold;
  margin: 12px 0;
  letter-spacing: 1px;
}

h5 {
  font: 14px/24px $body-font-stack;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 12px 0 12px;
}

h6 {
  font: 14px/24px $body-font-stack;
  margin: 12px 0 12px 0;
  font-weight: bold;
}


/* Paragraphs
   -------------------------------------------------------------------------- */

p {
  margin-top: 0;
  margin-bottom: 24px;

  &.intro {
    font-size: 16px;
    font-weight: 500;
  }

  &.small {
    font-size: 12px;
    line-height: 18px;
  }

  &.large {
    font-size: 16px;
    line-height: 24px;
  }
}

/* Inline Text Styles
   -------------------------------------------------------------------------- */

strong.underline {
  border-bottom: 2px solid #ecbc49;
  font-weight: normal;
}

/* Images
   -------------------------------------------------------------------------- */

img {
  display: block; 
  //max-width: 97%; 
  margin: 0; 
  border: 1px solid #ddd; 
  padding: 11px; 
  background: #fff;

  &.wide {
    width: auto; 
    max-width: none;
  }
}

p img {
  margin: 0 6px;
  padding: 0;
  display: inline; 
  border: none; 
  line-height: 24px;
  vertical-align: middle; 
  background: transparent;
}

img.cleaner { 
  border: 0; 
  padding: 0; 
  background-color: transparent;
}


/* Lists
   -------------------------------------------------------------------------- */

ul {
}

ol, ul, dl {
  margin: 0 0 24px;

  ol, ul {
    margin-top: 12px;
    margin-bottom: 12px;
  }
}

ol li, ul li {
  margin-bottom: 0;
  line-height: 24px;
}

dl {
}

.semantic-list { 
  list-style-type: none; 
  padding-left: 0;
}

/* Tables
   -------------------------------------------------------------------------- */

caption {
  font-family: $heading-font-stack;
  font-style: italic;
  font-size: 16px;
  margin-bottom: 12px;
}

table {
  background: #fff;
  border-bottom: 1px solid #ddd;
  margin: 12px auto 18px;

  @include box-shadow(0 1px 5px rgba(0, 0, 0, 0.1));

  caption, td, th {
    line-height: 24px;
  }

  thead th, &.vertical th {
    background: $samurai-grey;
    color: #f6f3f0;
    font-family: $heading-font-stack;
    font-weight: normal;
    font-size: 16px;
    border-right: 1px solid $samurai-grey;
    text-align: left;
  }

  &.vertical th {
    text-align: right;
  }

  th {
    padding: 6px 10px;
  }

  td, tbody th {
    padding: 6px 10px 5px;
    border-bottom: 1px solid #ddd;
    border-right: 1px solid #eee;
  }

  tbody th {
    background-color: lighten(#f6f3f0, 3%);
  }

  td a.button { margin-right: 0; }
  td.action { text-align: center }

  &.wide {
    width: 100%;
  }

  &.wider {
    width: 780px;
    margin-left: -80px;
  }

  &.widest {
    width: 940px;
    margin-left: -160px;
  }

  &.zebra {
    tr:nth-child(even) {
      td, th { background-color: #F8F8F8; }
    }
  }

  &.centered {
    td, th { text-align: center; }
  }
}

.span-12 table.widest, .span-12 table.wider {
  margin-left: 0;
}

/* Forms
   -------------------------------------------------------------------------- */

fieldset {
}

label {
  line-height: 24px;
  display: inline-block;
  margin-top: 6px;
  margin-bottom: 6px;

  &.for_radio {
    margin-left: 3px;
    margin-right: 6px;
  }
}

input[type=text], input[type=password], input[type=email], input[type=search], textarea {
  margin-right: 8px;
  border: 1px solid #c4cacd;
  background: #fff;
  padding: 8px 8px 8px;
  width: $desktop_grid_unit*3 + $desktop_grid_gutter*2 - 18px; /* equivalent to span-3 */
  line-height: 18px;
  font-size: 14px;
  font-family: $body-font-stack;
  @include box-shadow(0 0 5px rgba(88, 153, 192, 0.0));

  &:focus {
    outline: none;
    border-color: #9fc2c9;
    @include box-shadow(0 0 5px rgba(88, 153, 192, 0.41));
  }
}

input[type=radio], input[type=checkbox] {
  width: auto;
  margin-right: 0;
}

.field-group {
  p {
    float: left;
  }
}

form {
  p {
    margin-bottom: 12px;
  }

  .field {
    margin-bottom: 12px;
  }

  .actions {
    border-top: 1px solid #E1E2E1;
    padding: 11px 0 12px 0;
    margin-top: 12px;
    margin-bottom: 24px;
  }
}


/* Horizontal Rule
   -------------------------------------------------------------------------- */

hr {
  margin: 24px 0 23px;
}

hr.space {
  border-color: transparent;
}

/* =============================================================================
   Objects
   ========================================================================== */

.highlighted-block {
  background: #eeedeb;
  background: rgba(0, 0, 0, 0.03);
  padding: 0 10px;
}

/* Buttons
   -------------------------------------------------------------------------- */

.button, button, input[type=button], input[type=submit], input[type=reset] {
  display: inline-block;
  @include border-radius(5px);
  border: none;
  font-family: $heading-font-stack;
  font-weight: bold;
  text-transform: uppercase;
  text-decoration: none;
  text-align: center;
  line-height: 24px;
  color: #fff;
  background: #232d33;
  padding: 6px 12px 6px;
  margin: 6px 0 6px 0;

  -webkit-transition: all 0.25s;
  -moz-transition: all 0.25s;
  -o-transition: all 0.25s;
  transition: all 0.25s;

  &:hover, &:focus {
    color: #fff;
    background: #303e46;
  }

  &:visited {
    color: #fff;
  }

  &:active {
    @include box-shadow(inset 0 3px 6px rgba(0, 0, 0, 0.4));
    -webkit-transition-duration: 0.1s;
  }

  &.disabled {
    pointer-events: none;
  }
}

p .button {
  margin-left: 5px;
  margin-right: 5px;
}

p.buttons .button:first-child {
  margin-left: 0;
}

.small.button {
  @include border-radius(3px);
  font-size: 10px;
  letter-spacing: 1px;
  line-height: 12px;
  padding: 6px 8px;
}

.big.button {
  @include border-radius(10px);
  font-size: 23px;
  line-height: 36px;
  padding: 12px 22px;
  margin-top: 12px;
  margin-bottom: 24px;
}

.outlined.button {
  border-width: 2px;
  border-style: solid;
  background-color: transparent !important;

  padding: 4px 12px;

  &.small {
    padding: 4px 8px;
  }

  &.big {
    padding: 10px 22px;
  }
}

.red.button {
  background-color: #bf3d30;
  border-color: #bf3d30;
  &:hover { background-color: #d04234; }
  &:active { background-color: #bf3d30; }

  &.outlined { 
    color: #bf3d30; 

    &:hover {
      background-color: #bf3d30 !important;
      color: #fff;
    }
  }
}

.blue.button {
  background-color: #244e75;
  border-color: #244e75;
  &:hover { background-color: #1d5a93; }
  &:active { background-color: #244e75; }

  &.outlined { 
    color: #244e75; 

    &:hover {
      background-color: #244e75 !important;
      color: #fff;
    }
  }
}

.orange.button {
  background-color: #d7814c;
  border-color: #d7814c;
  &:hover { background-color: #e97537; }
  &:active { background-color: #d7814c; }

  &.outlined { 
    color: #d7814c; 

    &:hover {
      background-color: #d7814c !important;
      color: #fff;
    }
  }
}

.teal.button {
  background-color: #587f87;
  border-color: #587f87;
  &:hover { background-color: #588d98; }
  &:active { background-color: #587f87; }

  &.outlined { 
    color: #587f87; 

    &:hover {
      background-color: #587f87 !important;
      color: #fff;
    }
  }
}

.green.button {
  background-color: #6b9679;
  border-color: #6b9679;
  &:hover { background-color: darken(#6b9679, 10%); }
  &:active { background-color: #6b9679; }

  &.outlined { 
    color: #6b9679; 

    &:hover {
      background-color: #6b9679 !important;
      color: #fff;
    }
  }
}

.grey.button {
  background-color: #232d33;
  border-color: #232d33;
  &:hover { background-color: lighten(#232d33, 10%); }
  &:active { background-color: #232d33; }

  &.outlined { 
    color: #232d33; 

    &:hover {
      background-color: #232d33 !important;
      color: #fff;
    }
  }
}

.light.button, .cream.button {
  background-color: #f5f4f2;
  border-color: #f5f4f2;
  color: #232d33;
  &:hover { background-color: #fff; color: #232d33; }
  &:active { background-color: #f6f3f0; color: #232d33; }

  &.outlined { 
    color: #f5f4f2; 

    &:hover {
      background-color: #f5f4f2 !important;
      color: #232d33;
    }
  }
}

/* =============================================================================
   Branding and Layout-specific styles
   ========================================================================== */

#Litle-branding {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1;
  color: #f5f4f2;
  height: 70px;
  @include box-shadow(0 3px 10px rgba(0, 0, 0, 0.5));

  .wrapper {
    position: relative;
    height: 70px;
  }

  hgroup {
    margin-top: 10px;
    line-height: 50px;
  }

  .logo {
    float: left;
    width: 0;
    height: 0;
    margin: 0 0 0 0;

  }
}
#content {
  width: 800px;
  padding: 0 380px;
  margin-top: -9px;
 
  h1, header {
    margin-top: 0;
    margin-bottom: 0;
    padding: 24px 160px 40px;
    text-align: center;
    width: 460px;
    margin-left: -160px;
  }

  header h4 {
    text-align: center;
    letter-spacing: 0;
    font-weight: normal;
    font-size: 18px;
    line-height: 26px;
    margin: 0;
  }

  section {
    width: 460px;
    margin-left: -160px;
    padding: 0px 160px 20px;
  }
}
