<?php

namespace Esolving\ShopcartBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends EntityRepository {

    public function findByCriteria($options = array()) {
        $best_sellers = $options['best_sellers'];
        $bad_sellers = $options['bad_sellers'];
        $date_start = $options['date_start'];
        $date_end = $options['date_end'];
        $just_date = $options['just_date'];
        $language = $options['language'];
        $categoryId = $options['categoryId'];
        
        $qb = $this->createQueryBuilder('item');
        
        $qb
                ->addSelect('service', 'service_languages', 'cart', 'cart_moderations','service_categories')
                ->join('item.cart', 'cart')
                ->join('cart.moderations', 'cart_moderations')
                ->join('item.service', 'service')
                ->join('service.categories','service_categories')
                ->join('service.languages', 'service_languages')
                ->where($qb->expr()->eq('service_languages.language', ':service_languages_language'))
                ->andWhere($qb->expr()->eq('cart_moderations.success', ':cart_moderations_success'));
        
        if ($best_sellers && !$bad_sellers) {
            $qb
                    ->addSelect('SUM(item.quantity) as amount')
                    ->orderBy('amount', 'desc')
                    ->groupBy('item.service');
        }
        
        if ($bad_sellers && !$best_sellers) {
            $qb
                    ->addSelect('SUM(item.quantity) as amount')
                    ->orderBy('amount', 'asc')
                    ->groupBy('item.service');
        }
        
        if ($best_sellers && $bad_sellers) {
            $qb
                    ->addSelect('SUM(item.quantity) as amount')
                    ->orderBy('service_languages.name')
                    ->groupBy('item.service');
        }
        
        if ($date_start && !$date_end) {
            $qb->andWhere($qb->expr()->like('cart_moderations.dateSuccess', $qb->expr()->literal('%' . $date_start->format('Y-m-d') . '%')));
        }
        
        if ($date_start && $date_end) {
            $qb->andWhere($qb->expr()->between('cart_moderations.dateSuccess', $qb->expr()->literal($date_start->format('Y-m-d')), $qb->expr()->literal($date_end->format('Y-m-d'))));
        }
        
        if ($just_date) {
            $qb->andWhere($qb->expr()->like('cart_moderations.dateSuccess', $qb->expr()->literal('%' . $just_date->format('Y-m-d') . '%')));
        }
        
        if($categoryId){
            $qb->andWhere($qb->expr()->eq('service_categories.id', $qb->expr()->literal($categoryId)));
        }
        
        $qbLast = $qb->setParameters(array(
                    'cart_moderations_success' => true,
                    'service_languages_language' => $language
                ))
                ->getQuery();
        $items = $qbLast->getResult();
        return $items;
    }

    public function findAllItemByCartIdByLanguage($xcart_id, $xlanguage) {
        $qb = $this->createQueryBuilder('item');
        $q = $qb->addSelect('cart', 'service', 'service_languages')
                ->join('item.cart', 'cart')
                ->join('item.service', 'service')
                ->join('service.languages', 'service_languages')
                ->where($qb->expr()->eq('cart.id', ':cart_id'))
                ->andWhere($qb->expr()->gte('cart.expiredAt', ':date_now'))
                ->andWhere($qb->expr()->eq('cart.success', ':cart_success'))
                ->andWhere($qb->expr()->eq('cart.status', ':cart_status'))
                ->andWhere($qb->expr()->eq('service_languages.language', ':service_language'))
                ->setParameters(array(
                    'cart_status' => true,
                    'cart_success' => false,
                    'date_now' => new \DateTime(),
                    'cart_id' => $xcart_id,
                    'service_language' => $xlanguage
                ))
                ->getQuery()
        ;
        return $q->getResult();
    }

    public function findOneByServiceIdByCartIdNoSuccess($xservice_id, $xcart_id) {
        $qb = $this->createQueryBuilder('item');
        $q = $qb
                ->addSelect('service', 'cart')
                ->join('item.service', 'service')
                ->join('item.cart', 'cart')
                ->where($qb->expr()->eq('service.id', ':service_id'))
                ->andWhere($qb->expr()->eq('cart.id', ':cart_id'))
                ->andWhere($qb->expr()->eq('cart.success', ':cart_success'))
                ->setParameters(array(
                    'service_id' => $xservice_id,
                    'cart_id' => $xcart_id,
                    'cart_success' => 0
                ))
                ->getQuery()
        ;
        return $q->getOneOrNullResult();
    }

}
