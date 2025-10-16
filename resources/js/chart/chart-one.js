import ApexCharts from "apexcharts";

// ===== chartOne
const chart01 = () => {
  const chartOneOptions = {
    series: [
      {
        name: "Income",
        data: typeof incomeChartData !== 'undefined' ? incomeChartData : [],
      },
    ],
    colors: ["#1d4ed8"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "area",
      height: "100%",
      maxWidth: "100%",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "39%",
        borderRadius: 5,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 4,
      colors: ["transparent"],
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
      fontFamily: "Outfit",

      markers: {
        radius: 99,
      },
    },
    yaxis: {
      title: false,
    },
    grid: {
      yaxis: {
        lines: {
          show: true,
        },
      },
    },
    fill: {
      opacity: 1,
    },

    tooltip: {
      enabled: true,
      custom: function({ series, seriesIndex, dataPointIndex, w }) {
        const value = series[seriesIndex][dataPointIndex];
        const monthNames = [
          "Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        const category = monthNames[dataPointIndex]; // nama bulan
        return `
          <div style="padding:10px; background:#60A5FA; color:white; border-radius:5px;">
            <strong>${category}</strong><br/>
            Income: Rp ${value.toLocaleString('id-ID')}
          </div>
        `;
      }
    },
  };

  const chartSelector = document.querySelector("#chartOne");

  if (chartSelector) {
    const chart = new ApexCharts(chartSelector, chartOneOptions);
    chart.render();
}
};

export default chart01;
