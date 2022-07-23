<template>
  <Bar
    :chart-options="chartOptions"
    :chart-data="chartData"
    :chart-id="chartId"
    :dataset-id-key="datasetIdKey"
    :width="width"
    :height="height"
  />
</template>

<script>
import { Bar } from 'vue-chartjs'

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: {
    Bar
  },
  props: {
    chartId: {
      type: String,
      default: 'bar-chart'
    },
    datasetIdKey: {
      type: String,
      default: 'label'
    },
    width: {
      type: Number,
      default: 200
    },
    height: {
      type: Number,
      default: 300
    },
  },
  data() {
    return {
      chartData: {
        labels: [
          'Pork Chops ',
          'Chicken Neck',
          'Wagyu Beef',
          'Pork Ribs',
          'Tilapia',
          'Chicken Thigh',
          'Chicken Wings'
        ],
        datasets: [
          {
            label: 'Kg(sold)',
            backgroundColor: '#f97316',
            data: [400, 203, 122, 397, 102, 404 , 505]
          }
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    }
  }
}
</script>
