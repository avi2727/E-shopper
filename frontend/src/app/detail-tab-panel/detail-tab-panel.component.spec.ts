import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailTabPanelComponent } from './detail-tab-panel.component';

describe('DetailTabPanelComponent', () => {
  let component: DetailTabPanelComponent;
  let fixture: ComponentFixture<DetailTabPanelComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DetailTabPanelComponent]
    });
    fixture = TestBed.createComponent(DetailTabPanelComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
