<?php


namespace Talvbansal\TwillSite;

/**
 * Trait HasPermalinks
 * @package Talvbansal\TwillSite
 *
 * Twill can generate slugs but not the full permalink.
 * This trait makes a single accessor to generate a permalink from a defined route and slug.
 *
 * The 2 properties needed for this to work are $sluggableRoute which accepts a route name.
 * and optionally a $sluggableKey value that defaults to slug which is used in the route generation
 * for the $model->slug property to be passed to.
 */
trait HasPermalinks
{
    public function getPermalinkAttribute() : string
    {
        if(!$this->sluggableRoute){
            throw new \Exception("Route to generate permalink for class ".__CLASS__." is not defined. (The \$sluggableRoute property is not defined.)");
        }

        $key = $this->sluggableKey ?? 'slug';

        return route($this->sluggableRoute, [$key => $this->slug]);
    }
}
