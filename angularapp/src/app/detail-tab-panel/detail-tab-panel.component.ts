import { Component, Input  } from '@angular/core';
import { UserdataService } from '../services/userdata.service';

@Component({
  selector: 'app-detail-tab-panel',
  templateUrl: './detail-tab-panel.component.html',
  styleUrls: ['./detail-tab-panel.component.css']
})
export class DetailTabPanelComponent {
  activeTab: string = 'tab-pane-1';
  @Input() id: string | null | undefined;
  productData: any;
  constructor(private userdataService:UserdataService ) { }
  changeTab(tabId: string): void {
    this.activeTab = tabId;
  }
  ngOnInit() {
    this.userdataService.getproductdetails(this.id).subscribe((res:any)=>{
      this.productData=res;
   })
  }
 
}

