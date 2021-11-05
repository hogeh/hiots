DELETE FROM `#__content_types` WHERE `type_alias` IN ('com_hiots.hiot', 'com_hiots.category');

DROP TABLE IF EXISTS `#__hiots`;
DROP TABLE IF EXISTS `#__hiots_records`;
DROP TABLE IF EXISTS `#__hbrewsessions`;
