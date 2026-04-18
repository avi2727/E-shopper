import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { UserComponent } from './admin/admin-homepage/adminHomePage.component';

import { authGuard } from './auth.guard';

import { HomepageComponent } from './homepage/homepage.component';
import { ShopComponent } from './shop/shop.component';
import { ProductDetailComponent} from './product-detail/product-detail.component';
import { ShoppingCartComponent } from './shopping-cart/shopping-cart.component';
import { CheckoutComponent } from './checkout/checkout.component';
import { ContactusComponent } from './contactus/contactus.component';
import { ProductListComponent } from './admin/product-list/product-list.component';
import { CategoryListComponent } from './admin/category-list/category-list.component';
import { SubcategoryListComponent } from './admin/subcategory-list/subcategory-list.component';
import { OrderComponent } from './order/order.component';
// import { LoginComponent } from './admin/login/login.component';
// import { SignupComponent } from './admin/signup/signup.component';



const routes: Routes = [
  {
    path: 'userlist',
    component: UserComponent
  },

  { path: '', component: HomepageComponent, pathMatch: 'full' },
  // { path: 'admin/login', component: LoginComponent },
  // { path: 'admin/signup', component: SignupComponent },
  { path: 'admin/product-list', component: ProductListComponent },
  { path: 'admin/category-list', component: CategoryListComponent },
  { path: 'admin/subcategory-list', component: SubcategoryListComponent },
  // { path: 'admin/adminHomePage', component: UserComponent, canActivate:[authGuard]},
  { path: 'admin/adminHomePage', component: UserComponent},
  { path: 'shop', component: ShopComponent},
  { path: 'detail/:id', component: ProductDetailComponent},
  { path: 'cart', component: ShoppingCartComponent},
  { path: 'checkout', component: CheckoutComponent,canActivate:[authGuard]},
  { path: 'contactus', component: ContactusComponent},
  { path: 'order', component: OrderComponent},
  
];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
