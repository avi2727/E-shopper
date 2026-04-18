import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { UserdataService } from '../services/userdata.service';
@Component({
  selector: 'app-shop',
  templateUrl: './shop.component.html',
  styleUrls: ['./shop.component.css']
})
export class ShopComponent implements OnInit {

  category: any;
  filterData: any[] = [];
  showCategoryData: boolean = true;
  subcategory:any;
  productId: string | null | undefined;
  productData: any; // Remove [0] here
  quantity: number = 1; // Initialize quantity to 1
  target:string = '';
  userId: any;

  constructor(
    private userdataService:UserdataService, 
    private route: ActivatedRoute,
    private router : Router
  ) { }

  ngOnInit() {
    this.route.queryParams.subscribe(params => {
      this.category = params['category'];
      this.subcategory = params['subcategory'];
      this.filterProducts();
    });
  }


  filterProducts(): void {
    const priceFilter = (document.querySelector('input[name="price"]:checked') as HTMLInputElement).value;
    const colorFilter = (document.querySelector('input[name="color"]:checked') as HTMLInputElement).value;
    const sizeFilter = (document.querySelector('input[name="size"]:checked') as HTMLInputElement).value;
    this.userdataService.filterby(priceFilter, colorFilter, sizeFilter,this.category, this.subcategory).subscribe((res: any) => {
    this.filterData = res.original;
    if(res.original.code==1){
            this.target ='<div class="alert alert-danger">'+res.original.message+'</div>';
          }
          setTimeout(() => {
            this.target = '';
          }, 5000);
          this.showCategoryData = !(this.filterData && this.filterData.length > 0);
    });

  
}

addToCart(productId: any) {
  const userDataString = localStorage.getItem('userData');
  let userId = null;
  if (userDataString) {
    const userData = JSON.parse(userDataString);
    userId = userData.userID;
  }

  const cartItem = {
    quantity: this.quantity,
    productId: productId,
    userId: userId
  };

  this.userdataService.addtocart(cartItem).subscribe((res: any) => {
    if (res.code == 1) {
      this.target = '<div class="alert alert-success"> Success!' + res.message + '</div>';

      setTimeout(() => {
        this.router.navigate(['/cart']);
      }, 1000);
    } else if (res.code == 2) {
      this.target = '<div class="alert alert-danger"> Error!' + res.message + '</div>';
    }

    setTimeout(() => {
      this.target = '';
    }, 2000);
  });

  // If userId is null, store the cartData in session storage
  if (!userId) {
    const cartDataString = sessionStorage.getItem('cartData');
    let cartData = cartDataString ? JSON.parse(cartDataString) : [];
    cartData.push(cartItem);
    sessionStorage.setItem('cartData', JSON.stringify(cartData));
  }
}



}
