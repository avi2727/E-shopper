import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserComponent } from './admin/admin-homepage/adminHomePage.component';
import { HttpClientModule } from '@angular/common/http';
import { HeaderComponent } from './header/header.component';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { HomepageComponent } from './homepage/homepage.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatIconModule} from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { FooterComponent } from './footer/footer.component';
import { ShopComponent } from './shop/shop.component';
import { ProductDetailComponent } from './product-detail/product-detail.component';
import { ShoppingCartComponent } from './shopping-cart/shopping-cart.component';
import { CheckoutComponent } from './checkout/checkout.component';
import { ContactusComponent } from './contactus/contactus.component';
import { DetailTabPanelComponent } from './detail-tab-panel/detail-tab-panel.component';
import { ProductListComponent } from './admin/product-list/product-list.component';
import { CategoryListComponent } from './admin/category-list/category-list.component';
import { SubcategoryListComponent } from './admin/subcategory-list/subcategory-list.component';
import { UserListComponent } from './admin/user-list/user-list.component';
import {MatTableModule} from '@angular/material/table';
import {MatPaginatorModule} from '@angular/material/paginator';
import {MatFormFieldModule} from '@angular/material/form-field';
// import { LoginComponent } from './admin/login/login.component';
// import { SignupComponent } from './admin/signup/signup.component';
import { ToastrModule } from 'ngx-toastr';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import { OrderComponent } from './order/order.component';



@NgModule({
  declarations: [
    AppComponent,
    UserComponent,
    HeaderComponent,
    // LoginComponent,
    // SignupComponent,
    HomepageComponent,
    FooterComponent,
    ShopComponent,
    ProductDetailComponent,
    ShoppingCartComponent,
    CheckoutComponent,
    ContactusComponent,
    DetailTabPanelComponent,
    ProductListComponent,
    CategoryListComponent,
    SubcategoryListComponent,
    UserListComponent,
    OrderComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatButtonModule,
    MatIconModule,
    MatTableModule,
    MatPaginatorModule,
    MatFormFieldModule,
    MatSnackBarModule,
    ToastrModule.forRoot() 
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
