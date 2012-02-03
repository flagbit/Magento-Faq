Magento-Faq
===========

Adds a new FAQ item to the CMS menu in the backend. This allows you to supply your customers with answers to frequent questions or build a knowledge base increasing the customers shopping experience, reducing support costs and improving search engine ranking with your keywords.

Setup
-----

After installation the FAQ list is availible at http://example.com/your-magento-path/faq. You can add a link to the FAQ module in any static block or page like this: {{store direct_url="faq"}}.

Features
--------

* Full format control with HTML (WYSIWYG)
* Categorizing of FAQ items
* Every entry can be enabled/disabled individually
* German, Dutch and Russian Localization

Open Feature Requests
----------------

* Sorting of FAQ items within a category
* Add Meta-Information for FAQ items (like for products)

Contributions are highly appreciated.

FAQ
---

I'm going to install Flagbit Change Attribute Set extension and I would like ask you what happen to attribute that doesn't belong anymore to the target attribute set. Are they deleted from database records or they are orphans?

They are orphaned. Means if you accidently pick the wrong product and change back your attribute values are still there. if you want to clean up you have to do it manually.
