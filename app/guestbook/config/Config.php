<?php
declare(strict_types=1);

namespace Piv\Guestbook\Config;

class Config {
  // пути к директориям
  public const DIR_PUBLIC = '../public/';
  public const DIR_APP = '../src/';
  // пути к директориям для загрузки файлов
  public const DIR_TEMP_UPLOAD = '../public/upload/temp/';
  public const DIR_IMAGE_UPLOAD = '../public/upload/img/';
  public const DIR_SMALL_IMAGE_UPLOAD = '../public/upload/img/small/';
  public const DIR_FILE_TXT_UPLOAD = '../public/upload/txt/';
  // путь и имя файла маршрутов
  public const FILE_OF_ROUTES = '../../config/routes.yaml';
  // пути и имена конфигурационных файлов
  public const FILE_OF_MANIFEST = '../public/build/manifest.json';
  public const FILE_OF_ASSETS = 'assets.yaml';
  // путь к директории с фалами переводов
  public const FILE_OF_TRANSLATION = '../config/translations/';
  // имя файла, содержащего тему формы
  public const FILE_OF_FORM_THEME = 'form_div_layout.html.twig';

  public static function getGlobalVariableEnv(string $param)
  {
      return $_ENV[$param];
  }

  public static function checkIsDirToUploadedFiles()
  {
      if (!is_dir(self::DIR_TEMP_UPLOAD)) {
          mkdir(self::DIR_TEMP_UPLOAD);
      }
      if (!is_dir(self::DIR_IMAGE_UPLOAD)) {
          mkdir(self::DIR_IMAGE_UPLOAD);
      }
      if (!is_dir(self::DIR_SMALL_IMAGE_UPLOAD)) {
          mkdir(self::DIR_SMALL_IMAGE_UPLOAD);
      }
      if (!is_dir(self::DIR_FILE_TXT_UPLOAD)) {
          mkdir(self::DIR_FILE_TXT_UPLOAD);
      }
   }
}
