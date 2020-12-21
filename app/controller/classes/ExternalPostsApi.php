<?php defined('ABSPATH') || exit('No direct script access allowed');

class ExternalPostsApi
{
   private $domain;
   private $type;
   private $updatePeriod;
   
   public function __construct(string $domain, string $type, int $updatePeriod)
   {
      $this->domain        = $this->formatDomain($domain);
      $this->type          = $type;
      $this->updatePeriod  = $updatePeriod;
   }

   public function __get(string $prop)
   {
      $optName = isset(self::OPTIONS[$prop]) ? self::OPTIONS[$prop] : null;
      if (!$optName) return null;

      $opt = get_option($optName, false);
      return is_numeric($opt) ? (int) $opt : $opt;
   }

   public function __set(string $prop, $value)
   {
      $oldValue = $this->__get($prop);
      $oldValue ? update_option(self::OPTIONS[$prop], $value) : add_option(self::OPTIONS[$prop], $value);
   }

   public static function getPostTypes(string $domain = null)
   {
      $endpoint   = 'wp-json/wp/v2/types';

      $test       = wp_remote_get($domain . $endpoint);

      if (!self::isAvailable($test)) return null;

      return json_decode(wp_remote_retrieve_body($test), true);
   }

   public function getPosts(int $per_page = null, string $search = null)
   {
      $cache = $this->getPostsCache($per_page, $search);
      if (!empty($cache)) return $cache;

      $per_page   = $per_page ? $per_page : 9;
      $search     = $search   ? $search   : '';

      $domain     = $this->domain;
      $postType   = $this->type;

      $endpoint   = 'wp-json/wp/v2/' . $postType . '/';
      $endpoint  .= ($per_page)   ? '?per_page=' . $per_page : '';
      $endpoint  .= ($search)     ? '&search='   . $search   : '';

      $test       = wp_remote_get($domain . $endpoint);

      if (!$this->isAvailable($test)) return null;

      $posts      = json_decode(wp_remote_retrieve_body($test), true);
      $posts      = array_map(array($this, 'formatPost'), $posts);

      $this->setPostsCache($posts, $per_page, $search);

      return $posts;
   }

   public static function deletePostsCache(): void
   {
      global $wpdb;
      $table = $wpdb->prefix . 'options';
      $req   = "DELETE FROM $table WHERE `option_name` LIKE '%vvep_posts_cache%'";

      $wpdb->query($req);
   }

   private function getPostsCache(int $per_page = null, string $search = null): array
   {
      $cache  = $this->getCacheName();
      $cache .= ($per_page) ? '_per_page_' . $per_page : '';
      $cache .= ($search) ? '_search_' . $search : '';

      $cache = get_transient($cache);
      return ($cache) ? unserialize($cache) : [];
   }

   private function setPostsCache(array $posts, int $per_page = null, string $search = null): bool
   {
      $cache   = $this->getCacheName();
      $cache .= ($per_page) ? '_per_page_' . $per_page : '';
      $cache .= ($search) ? '_search' . $search : '';

      set_transient($cache, serialize($posts), $this->updatePeriod);
      return true;
   }

   private static function isAvailable($request): bool
   {
      return wp_remote_retrieve_response_code($request) === 200;
   }

   private function getCacheName(): string
   {
      $cacheName  = 'vvep_posts_cache';
      $cacheName .= '_' . $this->getDomainHost();
      $cacheName .= '_' . $this->type;

      return $cacheName;
   }

   private function formatDomain(string $domain): string
   {
      $domain   = (substr($domain, -1) === '/') ? $domain : $domain . '/';
      return $domain;
   }

   private function getDomainHost(): string
   {
      $data = parse_url($this->domain);
      return $data['host'];
   }

   private function formatPost(array $post): StdClass
   {
      $hasThumbnail = isset($post['_links']['wp:featuredmedia'][0]);
      $data = [
         'ID'            => $post['id'],
         'post_title'    => $post['title']['rendered'],
         'permalink'     => $post['link'],
         'post_content'  => $post['content']['rendered'],
         'excerpt'       => $post['excerpt']['rendered'],
         'post_thumbnail' => ($hasThumbnail) ? $this->getPostThumbnail($post['_links']['wp:featuredmedia'][0]['href']) : null
      ];

      return (object) $data;
   }

   private function getPostThumbnail(string $url)
   {
      $test = wp_remote_get($url);
      if (!$this->isAvailable($test)) return null;

      $img  = json_decode(wp_remote_retrieve_body($test), true);

      $res = (object) [
         'url'       => $img['guid']['rendered'],
         'title'     => $img['title']['rendered'],
         'alt_text'  => $img['alt_text'],
      ];

      return $res;
   }
}
