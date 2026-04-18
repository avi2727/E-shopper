import { Component, Input } from '@angular/core';
import { UserdataService } from '../../services/userdata.service';
import { User } from './user-list.model';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.css']
})
export class UserListComponent {
  studentData:any;
  userobj= new User();
  target:string = '';
  // isAddButtonClicked : boolean = false;
  profileForm:any= FormGroup;
  selectedImage: any;
  imagePreview:any;
  imagePreview_show:any;
  selectedFile: File | null = null;
  @Input() adminName: string | undefined;
  


  constructor(
    private userdataService:UserdataService, 
    private router:Router,
  ){ 
    this.profileForm = new FormGroup({
      id: new FormControl(''),
      name: new FormControl(''),
      email: new FormControl(''),
      contact: new FormControl('')
     
    });
    const navigation = this.router.getCurrentNavigation();
    if (navigation && navigation.extras && navigation.extras.state) {
      this.adminName = navigation.extras.state['userName'];
    }
  }
  // onload page we use ngOnInit 
  ngOnInit():void {
    this.showApiData();
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
     // Clear the image preview if no new image is selected
    this.imagePreview = '';
   }
  }
  populateFormWithData(studentData: any): void {
    this.profileForm.patchValue({
      id: studentData.id,
      name: studentData.name,
      email: studentData.email,
      contact: studentData.contact
    });
    this.imagePreview_show = 'http://127.0.0.1/laravel-angular/public/' + studentData.user_image;
  }

showApiData(){
  this.userdataService.getUserDataApi().subscribe((res:any)=>{
    this.studentData=res;
  })
}
addstudent() {
  //this.imagePreview = null;
  const formData = new FormData();
  
  // Append the user object properties to the formData
  formData.append('name', this.userobj.name);
  formData.append('email', this.userobj.email);
  formData.append('contact', this.userobj.contact);

  // Check if there is a selected image and append it to the formData
  if (this.selectedImage) {
    formData.append('image', this.selectedImage, this.selectedImage.name);
  }
  this.userdataService.addstudentdata(formData).subscribe((res :any) => {
    this.showApiData();
    this.userobj.name='';
    this.userobj.email='';
    this.userobj.contact='';
  
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
  deletedata(id:any){
    var c= confirm('Are you sure want to delete?')
    if(c){
      this.userdataService.deletedata(id).subscribe((res :any) =>{
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
    if (this.profileForm.invalid) {
      return;
    }
    const user_id: User = this.profileForm.value.id;
    const obj = {
      name : this.profileForm.value.name,
      email : this.profileForm.value.email,
      contact : this.profileForm.value.contact,
    }
    const formDataToSend: FormData = new FormData();
    formDataToSend.append('name', obj.name);
    formDataToSend.append('email', obj.email);
    formDataToSend.append('contact', obj.contact);
    
    // Add the image file to the FormData, if available
    if (this.selectedFile) {
      formDataToSend.append('image', this.selectedFile, this.selectedFile.name);
    }  
    this.userdataService.updatedata(formDataToSend,user_id).subscribe((res:any)=>{
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
