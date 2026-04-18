import { Component, Input, ViewChild } from '@angular/core';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { UserdataService } from '../../services/userdata.service';
import { Router } from '@angular/router';
import { Product } from './product.model';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';



@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.css']
})
export class ProductListComponent {
  displayedColumns: string[] = ['image', 'name', 'color', 'price', 'availability', 'action'];
    dataSource!: MatTableDataSource<any>;
    @ViewChild(MatPaginator) paginator!:MatPaginator ;
    
  
  productObj= new Product();
  availability: null | undefined ;
  trandy:null | undefined;
  justArrived:null | undefined;
  selectedImage: any;
  imagePreview: any;
  target:string = '';
  productData: any;
  producteditForm:any= FormGroup;
  imagePreview_show:any;
  selectedFile: File | null = null;
  constructor(
     private userdataService:UserdataService, 
     private router:Router,
  ){
    this.producteditForm = new FormGroup({
      id: new FormControl(''),
      name: new FormControl(''),
      description: new FormControl(''),
      price: new FormControl(''),
      size: new FormControl(''),
      color: new FormControl(''),
      availability: new FormControl(''),
      category_id: new FormControl(''),
      information: new FormControl(''),
      location: new FormControl(''),
      supcategory_id: new FormControl(''),
      trandy: new FormControl(''),
      justArrived: new FormControl('')
     
    });
    
  }
  ngOnInit():void {
    this.showApiData();
  }
  applyFilter(event: Event) {
    const inputValue = (event.target as HTMLInputElement).value;
  }

  showApiData(){
    this.userdataService.getProductDataApi().subscribe((res:any)=>{
      this.dataSource = new MatTableDataSource(res);
      this.dataSource.paginator=this.paginator;
    })
  }
  handleImageChange(event: any) {
    this.selectedImage=event.target.files[0];
    if(this.selectedImage){
     const reader = new FileReader;
     reader.onload =(e:any)=>{
       this.imagePreview=e.target.result;
     };
     reader.readAsDataURL(this.selectedImage);
    }else{
     this.imagePreview = '';
    }
   }

  addproduct() {
    const formData = new FormData();
    formData.append('name', this.productObj.name);
    formData.append('description', this.productObj.description);
    formData.append('price', this.productObj.price);
    formData.append('size', this.productObj.size);
    formData.append('color', this.productObj.color);
    formData.append('availability', this.productObj.availability);
    formData.append('category_id', this.productObj.category_id);
    formData.append('information', this.productObj.information);
    formData.append('location', this.productObj.location);
    formData.append('supcategory_id', this.productObj.supcategory_id);
    formData.append('trandy', this.productObj.trandy);
    formData.append('justArrived', this.productObj.justArrived);
    // Check if there is a selected image and append it to the formData
    if (this.selectedImage) {
      formData.append('image', this.selectedImage, this.selectedImage.name);
    }
   
    this.userdataService.addproductdata(formData).subscribe((res :any) => {
       this.showApiData();
      this.productObj.name='';
      this.productObj.description='';
      this.productObj.price='';
      this.productObj.size='';
      this.productObj.availability='';
      this.productObj.category_id='';
       this.productObj.color='';
      this.productObj.location='';
      this.productObj.information='';
      this.productObj.supcategory_id='';
      this.productObj.trandy='';
      this.productObj.justArrived='';
    
      if(res.code==1){
        this.target ='<div class="alert alert-success"> Success!'+res.message+'</div>';
      }else if(res.code==2){
        this.target ='<div class="alert alert-danger"> Error!'+res.message+'</div>';
      }
      setTimeout(() => {
        this.target = '';
      }, 2000);
    });
   
    }
   
    populateFormWithData(productData: any): void {
      this.producteditForm.patchValue({
        id: productData.id,
        name: productData.name,
        description: productData.description,
        price: productData.price,
        size: productData.size,
        availability: productData.availability,
        category_id: productData.category_id, 
        color: productData.color,
        information: productData.information,
        supcategory_id:productData.Supercategory_id,
        location:productData.location,
        trandy:productData.trandy,
        justArrived:productData.justArrived,
      });
      this.imagePreview_show = 'http://127.0.0.1/laravel-angular/public/' + productData.product_image;
    }
    deletedata(id:any){
      var c= confirm('Are you sure want to delete?')
      if(c){
        this.userdataService.deleteproductdata(id).subscribe((res :any) =>{
          this.showApiData();
          if(res.code==1){
            this.target ='<div class="alert alert-success"> Success!'+res.message+'</div>';
          }else if(res.code==2){
            this.target ='<div class="alert alert-danger"> Error!'+res.message+'</div>';
          }
          setTimeout(() => {
            this.target = '';
          }, 2000);
        });
      }
      
    }
    handleImageChange_new(event: Event) {
      const inputElement = event.target as HTMLInputElement;
      if (inputElement.files && inputElement.files.length > 0) {
        this.selectedFile = inputElement.files[0];
        const reader = new FileReader;
        reader.onload =(e:any)=>{
          this.imagePreview_show=e.target.result;
        };
        reader.readAsDataURL(this.selectedFile);
      } else {
        this.selectedFile = null;
      }
    }
    saveModifyData(){
      if (this.producteditForm.invalid) {
        return;
      }
      const user_id: Product = this.producteditForm.value.id;
      const obj = {
        name : this.producteditForm.value.name,
        description : this.producteditForm.value.description,
        price : this.producteditForm.value.price,
        size : this.producteditForm.value.size,
        availability : this.producteditForm.value.availability,
        category_id : this.producteditForm.value.category_id,
        color : this.producteditForm.value.color,
        information : this.producteditForm.value.information,
        supcategory_id : this.producteditForm.value.supcategory_id,
        location : this.producteditForm.value.location,
        trandy : this.producteditForm.value.trandy,
        justArrived : this.producteditForm.value.justArrived,
      }
      const formDataToSend: FormData = new FormData();
      formDataToSend.append('name', obj.name);
      formDataToSend.append('description', obj.description);
      formDataToSend.append('price', obj.price);
      formDataToSend.append('size', obj.size);
      formDataToSend.append('availability', obj.availability);
      formDataToSend.append('category_id', obj.category_id);
      formDataToSend.append('color', obj.color);
      formDataToSend.append('information', obj.information);
      formDataToSend.append('supcategory_id', obj.supcategory_id);
      formDataToSend.append('location', obj.location);
      formDataToSend.append('trandy', obj.trandy);
      formDataToSend.append('justArrived', obj.justArrived);
  
      
      // Add the image file to the FormData, if available
      if (this.selectedFile) {
        formDataToSend.append('image', this.selectedFile, this.selectedFile.name);
      }  
      this.userdataService.updateproductdata(formDataToSend,user_id).subscribe((res:any)=>{ 
        this.showApiData();
        if(res.code==1){
          this.target ='<div class="alert alert-success"> Success!'+res.message+'</div>';
        }else if(res.code==2){
          this.target ='<div class="alert alert-danger"> Error!'+res.message+'</div>';
        }
        setTimeout(() => {
          this.target = '';
        }, 2000);
      });
      
    }
}
