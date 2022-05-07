The Cinema Project

Pre-requirements:
- php 8.1.5
- composer

Setup steps:
- execute `composer install`in project root

Testing steps:
- execute `./vendor/bin/phpunit tests` ( Test it only on Thursdays. It's a joke, you can test it any time.)

Misc:
- PHP code is written following the latest standards.
- index.php can be used for trying different app workflow variations.

Technical comments (**please, read after the code review**):
- I used pennies to represent product prices in classes because calculations with floating numbers in php are extremely inaccurate.
This is risky, especially when code is used for payment transactions.
After calculations are done, final total cost and savings are converted to a precise float. 

- I wrote this code with abstraction and interfaces in my mind. Because of that, properties|methods that are 
hardcoded in some concrete classes can be easily abstracted.

- I used a strategy pattern for `offers` functionality, since there will be different
strategies implemented on products.

- Factory pattern is used in deciding which offer strategy should be applied.

- `CheckoutSystem` class represents the Facade design pattern. 

- I used an abstract Product class, since design enforces each new Product class to 
set the `type`. Product class uses two interfaces, I decided to follow this route by purpose, respecting the
letter `'I'` in `SOLID`. I decided to go with the `Product` inheritance architecture, mostly because my way of thinking
automatically goes to data object philosophies of popular frameworks. I used the "single table inheritance"
principle and reflection relationship between products and subproducts. I am open to discuss
potential improvements, since few design patterns can be implemented here that prefer `composition over inheritance`.

- The biggest candidate for `Product` inheritance replacement was Decorator pattern, so I can easily add
new product types and add additional attributes to it. 

- `ProductSimpleFactory` is not a design pattern when it is implemented in this manner. 
I just wanted to keep code for creating needed Products separated from the rest of the app.

- `Cart` takes care of `totalCost` and `savings` properties with the rest of other `Cart` responsibilities.

- Discounts per item should be tracked in `CartItem`.

- Cart->cartItems should be a collection of `CartItem` objects. In that case, it would
implement the `Iterator` design pattern.

- Product validation in `Cart` should be moved to a separate Validator Interface. Collection of validators can be applied
on the specific product. 
( examples: is it in stocks || are there prerequisites for addToCart method )

- Constructor property promotion available in php 8.1.5 can be used instead of old way constructor usage
- There should be no hardcoded values in code. Use descriptive constants. 

App in production:
- all translatable items should have translatable class (Product -> ProductTranslatable)
- I would have many to many `Product` relationship between parent `Product` and child `Product` (parent_product_id, child_product_id)
- I would rely on `Product->id` instead of `Product->type` that is used in this app. 
- With that decision, the type property would be obsolete, so I would remove it from the model.
