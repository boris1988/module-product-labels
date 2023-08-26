# Bperevyazko_ProductLabel

## Bperevyazko_ProductLabel module provides next possibilities:
- output discount labels at the image area without catalog rules for product page, product listing page, widgets, related/cross-sel/upsell products
- output product attributes at the image area  for product page, product listing page, widgets, related/cross-sel/upsell products

### Features
 - label position can be configured from admin configuration page
 - background for labels can be configured from admin configuration page
 - discount mask can be configured from admin configuration page

### Installation
1. ```sh
   composer require bperevyazko/module-product-label
   ```
2. ```sh
   bin/magento module:enable BPerevyazko_ProductLabel
   ```
3. ```sh
   bin/magento setup:upgrade
   ```

#### How to configure Discount label
Go to section ``Stores -> Configuration -> Bperevyazko -> Product labels -> General``
1. Enable Discount Label = Yes
2. Mask for discount - by default `-{D}%`, where `{D}` as discount value. You can change it.
3. Discount Label position - position at the product image area. By default `Top Left`. 
   Available options:  
   * top left, 
   * top right, 
   * bottom left, 
   * bottom right
4. Background Color -  the color for discount area


## Contacts
 - LinkedIn: www.linkedin.com/in/boris-pereviazko
 - Email: borisperevyazko@gmail.com

