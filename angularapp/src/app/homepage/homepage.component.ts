import { Component, HostListener } from '@angular/core';
import { Router } from '@angular/router';
import { UserdataService } from '../services/userdata.service';

@Component({
  selector: 'app-homepage',
  templateUrl: './homepage.component.html',
  styleUrls: ['./homepage.component.css'],
})
export class HomepageComponent {

  productData: any;
  trendyData:any;
  justArrivedData: any;
  count: number[] = []; 
  constructor(
    private userdataService:UserdataService, 
    private router:Router,
 ){}
 ngOnInit():void {
  this.getTrendyProduct();
  this.getJustArrivalProduct();
  this.getproductcount();
}
getTrendyProduct(){
  this.userdataService.getTrandyProductData().subscribe((res:any)=>{
    this.trendyData=res;
  });
}
  getJustArrivalProduct(){
    this.userdataService.getJustArrivedProductData().subscribe((res:any)=>{
      this.justArrivedData=res;
    });
  
}
getproductcount(){
  this.userdataService.getProductCount().subscribe((res:any)=>{
    this.count=res;
  });

}
navigateToShop(category: any) {
  this.router.navigate(['/shop'], { queryParams: { category: category } });
}
navigateToShoppage(subcategory: any) {
  this.router.navigate(['/shop'], { queryParams: { subcategory: subcategory } });
}
  // Scroll to top when the button is clicked
  scrollToTop(): void {
    window.scroll({
      top: 0,
      behavior: 'smooth'
    });
  }

  // Show/hide the button based on scroll position
  @HostListener('window:scroll')
  onWindowScroll(): void {
    const button = document.getElementById('btn-back-to-top');
    if (button) {
      button.style.display = (window.pageYOffset > 20) ? 'block' : 'none';
    }
  }
}
