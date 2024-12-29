<?php

namespace Sprint\Migration;


class Version20241229160355 extends Version
{
    protected $author = "admin";

    protected $description = "Миграция инфоблока Новости";

    protected $moduleVersion = "4.16.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $iblockId = $helper->Iblock()->getIblockIdIfExists('furniture_news_s1', 'news');
        $helper->Iblock()->saveProperty($iblockId, array (
  'NAME' => 'Автор',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'CODE' => 'AUTHOR',
  'DEFAULT_VALUE' => '',
  'PROPERTY_TYPE' => 'S',
  'ROW_COUNT' => '1',
  'COL_COUNT' => '30',
  'LIST_TYPE' => 'L',
  'MULTIPLE' => 'Y',
  'XML_ID' => NULL,
  'FILE_TYPE' => '',
  'MULTIPLE_CNT' => '5',
  'LINK_IBLOCK_ID' => '0',
  'WITH_DESCRIPTION' => 'N',
  'SEARCHABLE' => 'N',
  'FILTRABLE' => 'N',
  'IS_REQUIRED' => 'N',
  'VERSION' => '1',
  'USER_TYPE' => 'UserID',
  'USER_TYPE_SETTINGS' => NULL,
  'HINT' => '',
));
    
    }
}
