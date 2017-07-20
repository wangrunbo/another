<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Query;

/**
 * Favourites Controller
 *
 * @property \App\Model\Table\FavouritesTable $Favourites
 * @property \App\Model\Table\ProductsTable $Products
 */
class FavouritesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Products');
    }

    public function index()
    {
        $this->request->allowMethod('get');

        $favourites = $this->Favourites->find('active')
            ->where(['Favourites.user_id' => $this->Auth->user('id')])
            ->contain(['Products'])
            ->orderDesc('Favourites.created')
            ->toArray();

        $this->set(compact('favourites'));
    }

    public function add()
    {
        $this->request->allowMethod(['ajax', 'get']);
        $this->autoRender = false;
        if (empty($asin = $this->request->getQuery('asin'))) throw new NotFoundException();

        $product = $this->Products->find('active')->select('id')
            ->where([
                'asin' => $asin
            ])
            ->notMatching('Favourites', function (Query $q) {
                return $q->where(['Favourites.user_id' => $this->Auth->user('id')]);
            })
            ->first();

        if (!is_null($product)) {
            $favourite = $this->Favourites->newEntity([
                'user_id' => $this->Auth->user('id'),
                'product_id' => $product->id
            ]);

            if ($this->Favourites->save($favourite)) {
                $this->_success(__d('message', 'Successfully saved product to favourite list.'));
            } else {
                $this->_error(__d('message', 'Fail to save product to favourite list!'));
            }
        }

        return $this->redirect(['controller' => 'Products', 'action' => 'view', $asin]);
    }

    public function remove($id = null)
    {
        $this->request->allowMethod(['ajax', 'put']);
        $this->autoRender = false;

        $favourite = $this->Favourites->find()->where([
            'Favourites.id' => $id,
            'user_id' => $this->Auth->user('id')
        ])->first();

        if (is_null($favourite)) throw new BadRequestException();

        $this->Favourites->delete($favourite);

        return $this->redirect(['action' => 'index']);
    }
}
