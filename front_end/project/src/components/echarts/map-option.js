export const option = {
  title: {
    text: '景区热力分布图',
    subtext: '数据来源qunar.com',
    x: 'center'
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    orient: 'vertical',
    x: 'left',
    data: ['iphoneX']
  },
  dataRange: {
    min: 0,
    max: 500000,
    x: 'left',
    y: 'bottom',
    text: ['高', '低'],
    calculable: true
  },
  toolbox: {
    show: true,
    orient: 'vertical',
    x: 'right',
    y: 'center',
    feature: {
      mark: {
        show: true
      },
      dataView: {
        show: true,
        readOnly: false
      },
      restore: {
        show: true
      },
      saveAsImage: {
        show: true
      }
    }
  },
  roamController: {
    show: true,
    x: 'right',
    mapTypeControl: {
      'china': true
    }
  },
  series: [{
    name: 'heatPointMap',
    type: 'map',
    mapType: 'china',
    roam: false,
    itemStyle: {
      normal: {
        label: {
          show: true
        }
      },
      emphasis: {
        label: {
          show: true
        }
      }
    }

    
  }]
};
